<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\SalesOrderHeader as MD;
use App\CustomerShipmentHeader;
use App\Counter;
use DB;
use App\SalesInvoiceHeader;
use App\SalesOrderLine;
use App\ItemStock;

class SalesOrderHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MD::all();
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
        //000720190015
        $counter = Counter::find(5);
        $nomor = str_pad($counter->sequence_next_value, 4, 0, STR_PAD_LEFT);
        $arr["intnomorsales"] = str_pad(date("mY") . $nomor, 12, 0, STR_PAD_LEFT);
        $request->merge($arr);
        $data = MD::create($request->all());
        $counter->sequence_next_value += 1;
        $counter->save();
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
        $data = MD::with("detail.stock.inventoryproperty.item")->find($id);
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
        $data = MD::find($id);
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
        $a = CustomerShipmentHeader::where("sales_order_header_id", "=", $id);
        $line = SalesOrderLine::where("sales_order_header_id","=",$id)->get();
        foreach ($line as $key) {
            $item_stock = ItemStock::find($key->item_stock_id);
            $item_stock->qty += $key->qty;
            $item_stock->save();
            $key->delete();
        }

        if ($data == null) {
            $response = $this->responseBase("Tidak Ada Data", 404);
            return $response;
        } else {
              $data->delete();
                $a->delete();
                $flag = SalesInvoiceHeader::where("sales_order_header_id", "=", $id)->first();
                 if ($flag != null) {
                $flag->delete();
            }
                $response = $this->responseBase($data, 200);
                return $response;
            
            // if ($flag != null) {
            //     $flag->delete();
            //     $response = $this->responseBase("Data terdapat pembayaran", 214);
            //     return $response;
            // } else {
              
            // }
        }
    }

    //additional
    function getsorted($field, $sort, $limit)
    {
        $data = MD::select("*");
        $data = $data->orderBy($field, $sort);
        $data = $data->paginate($limit);
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function calculateHutang($customer_id)
    {
        $data["hutang"] = MD::where("customer_id", $customer_id)->sum("payment_remain");
        return $this->responseBase($data, 200);
    }

    public function detailHutang($customer_id)
    {
        $data["data"] = MD::with("Customer")->select("sales_order_header.*")->join("customer", "customer.id", "=", "sales_order_header.customer_id")
            ->orwhere("customer.name", "like", "%" . $customer_id . "%")
            ->orwhere("intnomorsales", "like", "%" . $customer_id . "%")
            ->where("sales_order_header.payment_remain", "!=", 0)
            ->get();
        return $this->responseBase($data, 200);
    }
    public function detailHutangID($customer_id)
    {
        $data = MD::with("Customer")->select("sales_order_header.*")
            ->join("customer", "customer.id", "=", "sales_order_header.customer_id")
            ->where("customer.id", "=", $customer_id)
            ->where("sales_order_header.payment_remain", "!=", 0)
            ->get();
        return $this->responseBase($data, 200);
    }

    public function getDataByCustomer($customer_id)
    {
        $data["data"] = MD::with("Customer")->select("sales_order_header.*")
            ->where("customer_id", "=", $customer_id)
            ->get();
        return $this->responseBase($data, 200);
    }

    public function getDataByCustomerNomor($customer_id, $nomor)
    {
        $data["data"] = MD::with("Customer")->select("sales_order_header.*")
            ->where("customer_id", "=", $customer_id)
            ->where("intnomorsales", "like", "%" . $nomor . "%")
            ->get();
        return $this->responseBase($data, 200);
    }

    public function getHutang()
    {
        $data["data"] = MD::where("payment_remain", "!=", 0)->orderby("createdOn", "desc")->get();
        foreach ($data["data"] as $key) {
            $key->customer;
        }
        return $this->responseBase($data, 200);
    }
}
