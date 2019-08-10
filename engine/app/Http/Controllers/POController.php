<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = $myDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 month"));;
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		if ($request->has("riwayat")) {
			$response = $this->client()->get("po-header/".$request->riwayat."/riwayat/" . "?date_start=" . $request->date_start . "&date_end=" . $request->date_end);
			$data["data"] =  json_decode($response->getBody())->data;
			return view("po.index", $data);
		} else {
			$response = $this->client()->get("po-header/" . "?date_start=" . $request->date_start . "&date_end=" . $request->date_end);
			$data["data"] =  json_decode($response->getBody())->data;
			return view("po.index", $data);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view("PO.form");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$array["po_total"] = 0;
		$array["po_total_paid"] = 0;
		$response = $this->post("po-header", $request->all());
		for ($i = 1; $i <= $request->count; $i++) {
			if ($request->has("data-item-id-" . $i)) {

				$new['po_header_id'] = $response['data']->id;
				$stringrequest = "data-item-id-" . $i;
				$new['inventory_property_id'] = $request->$stringrequest;
				$stringrequest = "data-qty-id-" . $i;
				$new['qty_buy'] = $request->$stringrequest;
				$new['qty_get'] = 0;
				$new['po_line_no'] = 0;

				$stringrequest = "data-unit-id-" . $i;
				$new['satuan_id'] = $request->$stringrequest;
				$request->merge($new);
				// dd($new);
				$this->post("po-line", $new);
			}
		}
		return redirect()->back()->with('message', "Data dibuat dengan nomor " . $response['data']->po_no . "  Lakukan Penerimaan <a target='_BLANK' href=" . url('/') . "/penerimaan/" . $response['data']->id . '/create' . ">Klik Disini</a>");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function detail($id)
	{
		$response = $this->get("po-header/$id/detail");
		return view("po.detail", $response);
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
		$response = $this->delete("po-header/$id");
		return $response;
	}
}
