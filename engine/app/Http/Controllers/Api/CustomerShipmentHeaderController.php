<?php

namespace App\Http\Controllers\Api;

use App\CustomerShipmentHeader as MD;
use App\SalesOrderHeader;
use App\SalesOrderLine;
use Illuminate\Http\Request;

class CustomerShipmentHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lastday = "";
        if ($request->date_start == null) {
            $request->date_start = date("Y") . "-" . date("m") . "-" . "01";
            $lastday = date('t', strtotime($request->date_start));
        }
        if ($request->date_end == null) {
            $request->date_end = date("Y") . "-" . date("m") . "-" . $lastday;
        }
        $data["content"] = MD::with("Sales", "Sales.Customer")
            ->where("createdOn", ">=", $request->date_start . " 00:00:00")
            ->where("createdOn", "<=", $request->date_end . " 23:59:59")
            ->orderby("createdOn", "desc")
            ->get();
        // $data = MD::all();
        $data["date_start"] = $request->date_start;
        $data["date_end"] = $request->date_end;
        $response = $this->responseBase($data, 200);
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = MD::create($request->all());
        $response = $this->responseBase($data, 201);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MD::find($id);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        $response = $this->responseBase($data, 200);
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = MD::where("sales_order_header_id", "=", $id)->first();
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        foreach ($request->all() as $key => $value) {
            $data->$key = $value;
        }
        $data->save();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MD::find($id);
        if ($data == null) {
            $response = $this->responseBase("Tidak Ada Data", 404);
            return $response;
        } else {
            $data->delete();
            $response = $this->responseBase($data, 200);
            return $response;
        }
    }

    //additional
    public function getData($start, $end)
    {
        $data = MD::with("Sales", "Sales.Customer")
            ->where("createdOn", ">=", $start . " 00:00:00")
            ->where("createdOn", "<=", $end . " 23:59:59")
            ->orderBy("createdOn", "desc")
            ->get();

        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function search(Request $request)
    {
        $count = count($request->key);
        $data = MD::with("Sales", "Sales.Customer")
            ->leftjoin("sales_order_header", "sales_order_header.id", "=", "customer_shipment_header.sales_order_header_id")
            ->leftjoin("customer", "customer.id", "=", "sales_order_header.customer_id");
        for ($i = 0; $i < $count; $i++) {
            $data = $data->where($request->key[$i], $request->operator[$i], $request->value[$i]);
        }
        $body["content"] = $data->get();
        $response = $this->responseBase($body, 200);
        return $response;
    }

    public function searchCustomer($key, $search)
    {
        $data = MD::with("Sales", "Sales.Customer")
            ->leftjoin("sales_order_header", "sales_order_header.id", "=", "customer_shipment_header.sales_order_header_id")
            ->leftjoin("customer", "customer.id", "=", "sales_order_header.customer_id");
        $data = $data->where($key, "like", "%" . $search . "%");
        $body["content"] = $data->get();
        $response = $this->responseBase($body, 200);
        return $response;
    }

    public function getDetail($sales_id)
    {
        $data = MD::with("Sales.Customer.Sales", "Sales.Detail.Stock", "Sales.Detail.Stock.Inventoryproperty", "Sales.Detail.Stock.Satuan", "Sales.Detail.Stock.Inventoryproperty.Item", "Supir", "Kenek")->where("sales_order_header_id", "=", $sales_id)->first();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function updateModal()
    {
        echo date("Y-m-d H:i:s");
        $date_start = "2020-01-01 00:00:00";
        $date_end = "2020-01-31 23:59:59";
        $data = SalesOrderHeader::with("detail")->wherebetween("createdOn", [$date_start, $date_end])->get();
        // $data = SalesOrderHeader::with("detail.stock")->where("id","=","21522")->get();
        foreach ($data as $key) {
            $total = 0;
            foreach ($key->detail as $lines) {
                if ($lines->price_per_satuan_id != 0) {
                    $total += $lines->stock->purchase_price * $lines->qty;
                    $line = SalesOrderLine::with("stock")->find($lines->id);
                    $line->sales_per_satuan_id = $lines->stock->purchase_price;

                    $line->save();
                } else {
                    $total += 0 * $lines->qty;
                    $line = SalesOrderLine::with("stock")->find($lines->id);

                    $line->sales_per_satuan_id = $lines->stock->purchase_price;
                    $line->save();

                }
                $key->modal = $total;
                $key->save();
            }
            echo "done for header id " . $key->intnomorsales . "|||" . $key->createdOn . "<br>";

        }
        echo "all done..";
    }
}
