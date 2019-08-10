<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PenjualanController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = $myDate = date("Y-m-d");
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$response = $this->get("customer-shipment-header/" . "?date_start=" . $request->date_start . "&date_end=" . $request->date_end);
		$data["data"] =  $response["data"];

		return view("penjualan.index", $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$data["supir"] = $this->getData("user/supir/role");
		$data["kenek"] = $this->getData("user/kenek/role");
		return view("penjualan.form", $data);
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
		/**
		 * Post Sales Order Header
		 */
		$tanggal = strtotime($request->due_date);
		$newtanggal = date("Y-m-d", $tanggal);
		$tanggalorder = strtotime($request->order_date);
		$newtanggalorder = date("Y-m-d", $tanggalorder);
		$head = [
			"customer_id" => $request->customer_id,
			"diskon" => 0,
			"due_date" => $newtanggal,
			"intnomorsales" => "",
			"order_date" => $newtanggalorder,
			'payment_remain' => $request->total_sales,
			"pos" => $request->pos,
			"retur" => 0,
			"status" => "C",
			"total_dp" => 0,
			"total_paid" => 0,
			"total_sales" => $request->total_sales,
			"modal" => 0,
			"print" => 0
		];
		$salesheads = $this->post("sales-order-header", $head);
		$saleshead = $salesheads["data"]->id;
		/**
		 * POST Shipment Header
		 */
		$tanggal = strtotime($request->var2);
		$newtanggal = date("Y-m-d", $tanggal);
		$shipmentheader = array();
		if ($request->has("staff1")) {
			$shipmentheader["sales1_id"] = $request->staff1;
		} else {
			$shipmentheader["sales1_id"] = null;
		}
		if ($request->has("staff2")) {
			$shipmentheader["sales2_id"] = $request->staff2;
		} else {
			$shipmentheader["sales2_id"] = null;
		}
		$shipmentheader["customer_shipment_status"] = "1";
		$shipmentheader["sales_order_header_id"] = $saleshead;
		$shipmentheader["date"] = $newtanggal;
		$responseshipmentheader = $this->post("customer-shipment-header", $shipmentheader);
		$shipmentheaderid = $responseshipmentheader["data"]->id;
		/**
		 * POST Sales order line
		 */
		$count = $request->count;
		$line = array();
		$shipmentline = array();
		$isi["sales_order_header_id"] = $saleshead;
		$modal = 0;

		for ($i = 0; $i < $count; $i++) {
			$j = $i + 1;
			$a = "data-item-id-" . $j;
			if($request->has($a)){
			
			$b = "data-qty-id-" . $j;
			$c = "data-harga-" . $j;
			$d = "data-diskon-id-" . $j;
			$e = "data-mod-id-" . $j;
			$f = "data-sub-id-" . $j;
			$a = $request->$a;
			$b = $request->$b;
			$c = $request->$c;
			$d = $request->$d;
			$e = $request->$e;
			$f = $request->$f;
			$isi["item_stock_id"] = $a;
			$isi["qty"] = $b;
			$isi["price_per_satuan_id"] = $c;
			$isi["sales_per_satuan_id"] = $e * $b;
			$isi["diskon"] = $d;
			$isi["qty_pending_send"]= 0;
			if ($isi["diskon"] == null) {
				$isi["diskon"] = 0;
			}
			$isi["bonus"] = 0;
			if ($isi["qty"] == 0) {
				$isi["bonus"] = 1;
			}
			$isi["retur"] = 0;
			$line['data'][$i] = $isi;
			if ($c != 0) {
				$modal += $e * $b;
			}
			$shipment = [
				"qty" => $b,
				"customer_shipment_header_id" => $shipmentheaderid,
			];
			$shipmentline["data"][$i] = $shipment;}
		}
		$responseline = $this->post("sales-order-line", $line);
		$responseshipmentline = $this->post("customer-shipment-line", $shipmentline);

		$ray = array();
		$ray["modal"] = $modal;
		$response3 = $this->put("sales-order-header/$saleshead", $ray);


		if ($request->has("prints")) {
			// $response = $this->client->get($this->base_uri("sales_order_line/detail/" . $saleshead));
			// $hasil2 = json_decode($response->getBody()->getContents());
			$response = $this->get("customer-shipment-header/detail/" . $saleshead);
			$name = "Laporan/Faktur/" . 'faktur-' . $saleshead . "" . date("Y-m-dh-i-s") . '.pdf';
			$pdf = PDF::loadView('report.penjualan-faktur', [
				"line" => $response["data"]->sales->detail,
				"data" => $response["data"]->sales,
			])->setOption('page-height', '185')->setOption('page-width', '215')->save($name);
			$printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName 'EPSON LX-310 ESC/P' $name";
			exec($printcmd);
			echo $name;

			$ray = array();
			$ray["print"] = 1;
			$response3 = $this->put("sales-order-header/$saleshead", $ray);
		}
		return redirect()->back()->with('message', "Sales Ditambahkan dengan nomor faktur " . $salesheads["data"]->intnomorsales);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$response = $this->get("customer-shipment-header/detail/" . $id);
		$response["supir"] = $this->getData("user/supir/role");
		$response["kenek"] = $this->getData("user/kenek/role");
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
		$response = $this->get("sales-order-header/$id");
		$data["data"] =  json_decode($response->getBody())->data;
		return view("penjualan.edit", $data);
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
		// dd($request->all());
		$response = $this->put("customer-shipment-header/$id", $request->only("sales1_id", "sales2_id"));
		$response = $this->put("sales-order-header/" . $response["data"]->id, $request->only("customer_id"));
		return redirect()->back()->with("message", "Penjualan diubah");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$response = $this->delete("sales-order-header/$id");
		return $response;
	}

	public function search(Request $request)
	{
		$response = $this->get("customer-shipment-header/" . $request->key . "/" . $request->search . "/searchCustomer");

		$data["data"] =  $response["data"];

		return view("penjualan.index", $data);
	}
}
