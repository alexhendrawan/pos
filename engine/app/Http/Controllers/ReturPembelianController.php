<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReturPembelianController extends Controller
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
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$response = $this->get("supplier-return-header/" . "?date_start=" . $request->date_start . "&date_end=" . $request->date_end);
		return view("retur-pembelian.index", $response);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view("retur-pembelian.form");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$purchaseheader = $this->getData("purchase-invoice-header/" . $request->nomor);
		$body = [
			"po_id" => $request->nomor,
			"supplier_code" => $request->supplier,
			"createdBy" => $request->createdBy
			
		];
		$response = $this->post("supplier-return-header", $body);
		$idretursupplier = $response['data']->id;
		$count = $request->count;
		$newline = array();
		$line = array();
		// $newline["supplier_return_header_id"]["id"] = $idretursupplier;
		$total = 0;
		for ($i = 1; $i <= $count; $i++) {
			$a = "data-item-id-" . $i;
			$b = "data-harga-id-" . $i;
			$c = "data-qty-id-" . $i;
			if ($request->has($a)) {
				$a = $request->$a;
				$b = $request->$b;
				$c = $request->$c;
				$newline = [
					"qty" => $c,
					"retur_price" => $b,
					"item_id" => $a,
					"supplier_return_header_id" => $idretursupplier,
				];
				$line["data"][$i - 1] = $newline;
				$total += $b * $c;
				// dd($line);
			}
		}
		$response = $this->post("supplier-return-line",$line);
		$update = [
			"invoice_total" => $purchaseheader->invoice_total - $total,
			"retur" => $purchaseheader->retur + $total
		];
		$response = $this->put("purchase-invoice-header/" . $request->nomor, $update);


		$update = [
			"po_total" => $purchaseheader->invoice_total - $total,
		];

		$response = $this->put("po-header/" . $response["data"]->poheader_id, $update);
		return redirect()->back()->with('message', "Return Supplier Ditambahkan");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$response = $this->get("supplier-return-header/" . $id);
		return view("retur-pembelian.detail", $response);
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$response = $this->delete("supplier-return-header/$id");
		return $response;
	}
}
