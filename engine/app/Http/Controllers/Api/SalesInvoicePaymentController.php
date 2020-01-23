<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\SalesInvoicePayment as MD;
use App\SalesOrderHeader;

class SalesInvoicePaymentController extends Controller
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
        $data["content"] = MD::with("Sales", "Sales.Customer")->where("createdOn", ">=", $request->date_start . " 00:00:00")->where("createdOn", "<=", $request->date_end . " 23:59:59")->get();
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
        $sales = SalesOrderHeader::find($request->sales_order_header_id);
        $sales->payment_remain -= $request->payment_value + $request->diskonrupiah;
        $sales->total_paid += $request->payment_value;

        $sales->diskon += $request->diskonrupiah;
        $sales->save();
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
        $data = MD::find($id);
        $selisih = $data->payment_value - $request->payment_value;
        $sales = SalesOrderHeader::find($data->sales_order_header_id);
        $sales->payment_remain += $selisih;
        $sales->total_paid += $selisih;
        $sales->save();
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
        $sales = SalesOrderHeader::find($data->sales_order_header_id);
        $sales->payment_remain += $selisih;
        $sales->total_paid += $selisih;
        $sales->save();
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
    public function getsorted($field, $sort, $limit)
    {
        $data = MD::select("*");
        $data = $data->orderBy($field, $sort);
        $data = $data->paginate($limit);
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function search(Request $request)
    {
        $count = count($request->key);
        $data = MD::select("sales_invoice_payment.*")->leftjoin("sales_order_header", "sales_order_header.id", "=", "sales_invoice_payment.sales_order_header_id")
            ->leftjoin("customer", "customer.id", "=", "sales_order_header.customer_id");
        for ($i = 0; $i < $count; $i++) {
            $data = $data->where($request->key[$i], $request->operator[$i], $request->value[$i]);
        }
        $body["content"] = $data->get();
        foreach ($body["content"] as $key) {
            $key->sales;
            $key->sales->customer;
        }
        $response = $this->responseBase($body, 200);
        return $response;
    }
}
