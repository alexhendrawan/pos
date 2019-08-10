<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;

class PiutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->date_start == null) {
            $request->date_start = $myDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 month"));
            ;
        }
        if ($request->date_end == null) {
            $request->date_end = date("Y-m-d");
        }
        $response = $this->client()->get("sales-invoice-payment/"."?date_start=".$request->date_start."&date_end=".$request->date_end);
        $data["data"] =  json_decode($response->getBody())->data;
        return view("piutang.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("piutang.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $body=[
            "payment_id" => "C",
            "payment_value" => $request->nilaibayar,
			"sales_order_header_id" => $request->sales,
			"sales_invoice_payment_id" => 0,
			"sales_invoice_payment_no" => 0,
            "bank_cash_id" => $request->bank,
            "diskonrupiah" => $request->nilaibayar*($request->diskon/100),
            "diskonpersen" => $request->diskon,
		];

        $response = $this->getData("sales-order-header/".$request->sales);
        if ($response->payment_remain > 0) {
            $this->post("sales-invoice-payment", $body);
            $update["payment_remain"] = $response->payment_remain - $request->nilaibayar;
            $response = $this->put("sales-order-header/".$request->sales, $update);
        }
        return redirect()->back()->with("message", "Pembayaran Berhasil");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->get("sales-invoice-payment/$id");
        return view("piutang.edit",$response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $response = $this->put("sales-invoice-payment/$id", $request->all());
        return view("piutang.edit",$response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       $response = $this->delete("sales-invoice-payment/$id");
       return $response;
   }

   public function search(Request $request)
   {
    $body["key"]=[
        $request->key
    ];
    $body["operator"]=[
        "="
    ];
    $body["value"]=[
        $request->search
    ];
    $response = $this->client()->get("sales-invoice-payment/search", [
        "json"=>$body
    ]);

    $data["data"] =  json_decode($response->getBody())->data;
    return view("piutang.index", $data);
}
}
