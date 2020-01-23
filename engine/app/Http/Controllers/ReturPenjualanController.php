<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class ReturPenjualanController extends Controller
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
		$response = $this->get("customer-return-header/" . "?date_start=" . $request->date_start . "&date_end=" . $request->date_end);
		return view("retur-penjualan.index", $response);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view("retur-penjualan.form");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// dd($request->all());
		// dd($request->request);
		$sales = $this->get("sales-order-header/" . $request->nomor);
		if ($request->count == 0) {
			return redirect()->back()->withInput($request->request->all())->with('error', "Data belum diinput atau belum di ENTER!! Coba Lagi!");
		}
		$count = $request->count;
		$total = 0;

		for ($i = 1; $i <= $count; $i++) {
			$b = "data-harga-id-" . $i;
			$c = "data-qty-id-" . $i;

			if ($request->has($b)) {
				$b = $request->$b;
				$c = $request->$c;
				$total += $b * $c;
			}
		}
		// if ($sales["data"]->payment_remain < $total) {
		// 	return redirect()->back()->withInput($request->request->all())->with('error', "Data yang dipilih akan mengakibatkan data faktur minus!");
		// }
		$header = [
			"status" => $request->status,
			"customer_id" => $request->customer_code,
			"sales_id" => $request->nomor,
			"createdBy" => $request->createdBy
			
		];
		$response = $this->post("customer-return-header", $header);
		$retur_id = $response["data"]->id;

		// dd($response);
		$newline = array();
		for ($i = 1; $i <= $count; $i++) {
			$a = "data-item-id-" . $i;
			$b = "data-harga-id-" . $i;
			$c = "data-qty-id-" . $i;

			if ($request->has($a)) {
				$a = $request->$a;
				$b = $request->$b;
				$c = $request->$c;
				$newline["data"][$i - 1]["customer_return_header_id"] = $retur_id;
				$newline["data"][$i - 1]["item_stock_id"] = $a;
				$newline["data"][$i - 1]["returprice"] = $b;
				$newline["data"][$i - 1]["qty"] = $c;
			}
		}

		$response = $this->post("customer-return-line", $newline);
		// $sales["data"]->total_sales -= $total;
		// $sales["data"]->payment_remain -= $total;
		// $sales["data"]->retur += $total;
		// $dataupdate = (array) $sales["data"];
		
		$update["total_sales"] = $sales["data"]->total_sales -$total;
		$update["payment_remain"] =$sales["data"]->payment_remain- $total;
		$update["retur"] =	$sales["data"]->retur + $total;
		$salesupdate = $this->put("sales-order-header/" . $request->nomor, $update);

		if ($request->has("print")) {
			$response = $this->get("customer-return-header/" . $retur_id);
			$name = "Laporan/ReturFaktur/Penjualan/" . 'Rfaktur-' . $retur_id . "" . date("Y-m-dh-i-s") . '.pdf';
			$pdf = PDF::loadView('report.retur-faktur-penjualan', [
				"data" => $response["data"],
				"line" => $response["data"]->detail,
			])->setOption('page-height', '185')->setOption('page-width', '215')->save($name);
			$printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName 'EPSON LX-310 ESC/P' $name";
			exec($printcmd);
			echo $name;
		}
		return redirect()->back()->with('message', "Return Penjualan Ditambahkan");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$response = $this->get("customer-return-header/" . $id);
		return view("retur-penjualan.detail", $response);
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
		$response = $this->delete("customer-return-header/$id");
		return $response;
	}
}
