<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenerimaanController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->has("riwayat")) {
			return view("penerimaan.index", $this->get("purchase-invoice-header/".$request->riwayat."/riwayat"));
		} else {
			return view("penerimaan.index", $this->get("purchase-invoice-header"));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($id)
	{
		$response = $this->get("po-header/penerimaan/$id/detail");
		return view("penerimaan.form", $response);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$tanggal = strtotime($request->invoice_date);
		$newtanggal = date("Y-m-d", $tanggal);
		$due_date = date('Y-m-d', strtotime($newtanggal . ' + ' . 30 . ' days'));
		$header["due_date"] = $due_date;
		$header["invoice_date"] = $newtanggal;
		$header["invoice_total"] = $request->invoice_total;
		$header["paid_total"] = 0;
		$header["purchase_invoice_status"] = "C";
		$header["sub_total"] = 0;
		$header["supplier_invoice_no"] = $request->supplier_invoice_no;
		$header["poheader_id"] = $request->po_header_id;
		$header["retur"] = 0;
		$header["createdBy"] = $request->createdBy;

		$response = $this->post("purchase-invoice-header", $header);

		$flag = 0;
		for ($i = 1; $i <= $request->count; $i++) {

			$a = "data-line-id-" . $i;
			$b = "qty-get-" . $i;
			$c = "pp-get-" . $i;
			$f = "sp-get-" . $i;
			$d = "size-get-" . $i;
			$e = "gudang-get-" . $i;
			$a = $request->$a;
			$b = $request->$b;
			$c = $request->$c;
			$d = $request->$d;
			$e = $request->$e;
			$f = $request->$f;

			if ($b > 0) {
				$newline = array();
				$line["price_per_satuan_id"] = $c;
				$line["qty"] = $b;
				$line["sell_per_satuan_id"] = $f;
				$line["po_header_id"] = $request->po_header_id;
				$line["po_line_id"] = $a;
				$line["purchase_invoice_header_id"] = $response['data']->id;
				$line["warehouse_id"] = $e;
				$this->post("purchase-invoice-line", $line);
			} else {
				$flag = 1;
			}
		}
		if ($flag == 0) {
			// $this->get("po-header/status/" . intval($request->po_header_id));
		}
		return redirect("penerimaan")->with('message', "Data dibuat dengan nomor faktur" . $response['data']->internal_invoice_no);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$data = $this->get("purchase-invoice-header/$id");
		return view("penerimaan.show", $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$data = $this->get("purchase-invoice-header/$id");
		return view("penerimaan.edit", $data);
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
		$tanggal = strtotime($request->invoice_date);
		$newtanggal = date("Y-m-d", $tanggal);
		$due_date = date('Y-m-d', strtotime($newtanggal . ' + ' . 30 . ' days'));
		$header["due_date"] = $due_date;
		$header["invoice_date"] = $newtanggal;
		$header["invoice_total"] = $request->invoice_total;
		$header["paid_total"] = 0;
		$header["purchase_invoice_status"] = "C";
		$header["sub_total"] = 0;
		$header["supplier_invoice_no"] = $request->supplier_invoice_no;
		$header["poheader_id"] = $request->po_header_id;
		$header["retur"] = 0;
		$header["createdBy"] = $request->createdBy;

		$response = $this->put("purchase-invoice-header/$id", $header);

		$flag = 0;
		for ($i = 1; $i <= $request->count; $i++) {

			$a = "data-line-id-" . $i;
			$b = "qty-get-" . $i;
			$c = "pp-get-" . $i;
			$d = "size-get-" . $i;
			$e = "gudang-get-" . $i;
			$f = "sp-get-" . $i;
			$g = "data-purchase-line-id-" . $i;

			$a = $request->$a;
			$b = $request->$b;
			$c = $request->$c;
			$d = $request->$d;
			$e = $request->$e;
			$f = $request->$f;
			$g = $request->$g;

				$newline = array();
				$line["price_per_satuan_id"] = $c;
				$line["qty"] = $b;
				$line["sell_per_satuan_id"] = $f;
				$line["po_header_id"] = $request->po_header_id;
				$line["po_line_id"] = $a;
				$line["purchase_invoice_header_id"] = $id;
				$line["warehouse_id"] = $e;
				$this->put("purchase-invoice-line/$g", $line);

		}
		return $this->backmessage("Data diubah");

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$response = $this->delete("purchase-invoice-header/$id");
		return $response;
	}
}
