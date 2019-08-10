<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PenjualanDetailController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{


		return view("penjualan-detail.index");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($id)
	{
		return view("penjualan-detail.form", ["sales_id" => $id]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $id)
	{
		$data["sales_order_header_id"] = $id;
		$data["new"] = true;
		$data["bonus"] = 0;
		$data["retur"] = 0;
		$data["qty_pending_send"] = 0;
		$data["sales_per_satuan_id"] = $request->sales_per_satuan_id;
		$data["price_per_satuan_id"] = $request->price_per_satuan_id;

		if ($request->price_per_satuan_id == 0) {
			$data["bonus"] = 1;
		}
		$request->merge($data);
		$this->post("sales-order-line", $request->all());
		return redirect("penjualan/$id")->with("message", "Penjualan Barang Ditambah");
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$response = $this->get("sales-order-line/" . $id);
		return view("penjualan.detail", $response);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$response = $this->get("sales-order-line/$id");
		return view("penjualan-detail.edit", $response);
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
		$response = $this->put("sales-order-line/$id", $request->except("_token", "_method"));
		return redirect()->back()->with("message", "Barang Penjualan Diedit");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$response = $this->delete("sales-order-line/$id");
		return $response;
	}

	public function search(Request $request)
	{
		$response = $this->get("sales-order-line/" . $request->search . "/searchCustomer");

		$data["data"] =  $response["data"];

		return view("penjualan-detail.index", $data);
	}
}
