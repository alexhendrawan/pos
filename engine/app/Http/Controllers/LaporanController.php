<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerReturnHeader;
use App\ItemStock;
use Illuminate\Http\Request;
use View;
use App\Sales_Order_Header;
use App\Pengeluaran;
use App\POLine;
use App\PurchaseInvoiceHeader;
use App\PurchaseInvoiceLine;
use App\PurchaseInvoicePayment;
use App\SalesOrderHeader;
use App\SalesOrderLine;
use App\Supplier;
use App\SupplierReturnHeader;
use App\User;
use App\Warehouse;
use App\StockMutation;

use PDF;
use DB;

class LaporanController extends Controller
{


	public function getlaporanstockopname(Request $request){
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$query = StockMutation::with("stock.inventoryproperty.item")->wherebetween("createdOn",[$request->date_start." 00:00:00", $request->date_end." 23:59:59"]);
		if($request->has("item_stock")){
			$query = $query->where("item_stock_id", $request->item_stock);
		}
		$query = $query->get();
		return view('report.stockopname', ["data" => $query, "start" => $request->date_start, "end" => $request->date_end]);
	}

	public function getlaporanbarang(Request $request)
	{
		$data = ItemStock::select();
		$filter["sell_price"] = 0;
		$filter["purchase_price"] = 0;
		if ($request->has("hargajual") && $request->has("hargabeli")) {

			$filter["sell_price"] = 1;
			$filter["purchase_price"] = 1;
			$data = $data->select("item.*", "item_stock.sell_price", "item_stock.purchase_price");
		} else if ($request->has("hargabeli")) {
			$filter["purchase_price"] = 1;
			$data = $data->select("item.*");
			$data = $data->select("item.*", "item_stock.purchase_price");
		} else if ($request->has("hargajual")) {
			$filter["sell_price"] = 1;
			$data = $data->select("item.*", "item_stock.sell_price");
		}
		$data = $data->leftjoin('satuan', 'satuan.id', '=', 'item_stock.satuan_id')
			->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
			->leftjoin('item', 'item.id', '=', 'inventory_property.item_id');
		if ($request->has("kategori")) {
			$data = $data->where("inventory_property.item_color_id", "=", $request->kategori);
		}
		if ($request->has("merk")) {
			$data = $data->where("inventory_property.brand_id", "=", $request->merk);
		}
		$data = $data->orderby("item.item_name", "asc")->get();

		return view(
			'report.daftarharga',
			[
				"data" => $data,
				"filter" => $filter
			]
		);
	}

	public function getlaporanstock(Request $request)
	{
		if ($request->date_start == null || $request->date_end == null) {
			$request->date_start = "1900-01-01";
			$request->date_end = date("Y-m-d");
		}
		$query = ItemStock::select("*", "category.name as catname", "brand.name as brandname", "satuan.name as satuanname")->leftjoin('satuan', 'satuan.id', '=', 'item_stock.satuan_id')
			->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
			// ->leftjoin('po_line', 'po_line.inventory_property_id', '=', 'inventory_property.id')
			// ->leftjoin('po_header', 'po_header.id', '=', 'po_line.po_header_id')
			->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
			->leftjoin('category', 'category.id', '=', 'inventory_property.item_color_id')
			->leftjoin('brand', 'brand.id', '=', 'inventory_property.brand_id')
			->leftjoin('warehouse', 'warehouse.id', '=', 'item_stock.warehouse_id');

		if (($request->has("merk") || $request->has("kategori") || $request->has("warehouse_id")) && (!$request->has("supplier") && !$request->has("customer"))) {

			$query = ItemStock::select("*", "category.name as catname", "brand.name as brandname", "satuan.name as satuanname")
				->leftjoin('satuan', 'satuan.id', '=', 'item_stock.satuan_id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				// ->leftjoin('po_line', 'po_line.inventory_property_id', '=', 'inventory_property.id')
				// ->leftjoin('po_header', 'po_header.id', '=', 'po_line.po_header_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->leftjoin('category', 'category.id', '=', 'inventory_property.item_color_id')
				->leftjoin('brand', 'brand.id', '=', 'inventory_property.brand_id')
				->leftjoin('warehouse', 'warehouse.id', '=', 'item_stock.warehouse_id');
			$name = "Laporan/Stok/Laporan Persediaan Barang per-" . Date("YmdHis") . ".pdf";
		} else if ($request->has("supplier")) {
			DB::enableQueryLog();
			$query = PurchaseInvoiceLine::select(DB::raw('distinct(item_stock.id),item_stock.*,satuan.name as satuanname, item.item_name, warehouse.warehouse_name'))
				->join('po_line', 'po_line.id', '=', 'purchase_invoice_line.po_line_id')
				->join('po_header', 'po_header.id', '=', 'po_line.po_header_id')
				->join('item_stock', 'item_stock.id', '=', 'po_line.item_stock_id')
				->join('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->join('item', 'item.id', '=', 'inventory_property.item_id')
				->join('satuan', 'satuan.id', '=', 'item_stock.satuan_id')
				->join('warehouse', 'warehouse.id', '=', 'item_stock.warehouse_id')
				->whereBetween('po_line.createdOn', [$request->date_start, $request->date_end])
				->where("po_header.supplier_id", "=", $request->supplier);
		} else if ($request->has("customer")) {
			$query = SalesOrderLine::select(DB::raw('distinct(item_stock.id),item_stock.*,satuan.name,item.item_name,warehouse.warehouse_name'))
				->join('sales_order_header', 'sales_order_header.id', '=', 'sales_order_line.sales_order_header_id')
				->join('item_stock', 'item_stock.id', '=', 'sales_order_line.item_stock_id')
				->join('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->join('item', 'item.id', '=', 'inventory_property.item_id')
				->join('satuan', 'satuan.id', '=', 'item_stock.satuan_id')
				->join('warehouse', 'warehouse.id', '=', 'item_stock.warehouse_id')
				->whereBetween('sales_order_line.createdOn', [$request->date_start, $request->date_end])
				->where("sales_order_header.customer_id", "=", $request->customer);
		}

		if ($request->has("kategori")) {
			$data = $query->where("inventory_property.item_color_id", "=", $request->kategori);
		}
		if ($request->has("merk")) {
			$data = $query->where("inventory_property.brand_id", "=", $request->merk);
		}

		if ($request->has("warehouse_id")) {
			$data = $query->where("item_stock.warehouse_id", "=", $request->warehouse_id)
				->get();
			$gudangnames = Warehouse::find($request->warehouse_id);
			return view('report.item_stock-ringkasan', ["data" => $data, "hargajual" => $request->hargajual, "hargabeli" => $request->hargabeli, "gudang" => $gudangnames->warehouse_name, "hargajualtotal" => $request->hargajualtotal, "hargabelitotal" => $request->hargabelitotal]);
		}
		if ($request->has("supplier")) {
			$data = $query->get();
			$suppliernames = Supplier::find($request->supplier);
			return view('report.item_stock-ringkasan', ["data" => $data, "suppliernames" => $suppliernames->supplier_name, "hargajual" => $request->hargajual, "hargabeli" => $request->hargabeli, "hargajualtotal" => $request->hargajualtotal, "hargabelitotal" => $request->hargabelitotal]);
		}
		if ($request->has("customer")) {
			$data = $query->get();

			$customernames = Customer::find($request->customer);
			return view('report.item_stock-ringkasan', ["data" => $data, "customernames" => $customernames->name, "hargajual" => $request->hargajual, "hargabeli" => $request->hargabeli, "hargajualtotal" => $request->hargajualtotal, "hargabelitotal" => $request->hargabelitotal]);
		}

		$data = $query->get();

		return view('report.item_stock-ringkasan', ["data" => $data, "category" => $data[0]->catname, "merk" => $data[0]->brandname, "hargajual" => $request->hargajual, "hargabeli" => $request->hargabeli, "hargajualtotal" => $request->hargajualtotal, "hargabelitotal" => $request->hargabelitotal]);
	}

	public function getlaporanpenjualan(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$date_end = $request->date_end;
		$request->date_end = date("Y-m-d", strtotime($request->date_end . "+1 days"));
		$data;
		$datasales;
		$datacustomer;
		$tglkirim = $request->date_end;
		if ($request->has("customer") && $request->has("item_stock")) {
			$data = SalesOrderLine::select("*", "customer.name as customername", "sales_order_line.qty as beli", "sales_order_header.createdOn as tanggalorder")
				->leftjoin('sales_order_header', 'sales_order_header.id', '=', 'sales_order_line.sales_order_header_id')
				->leftjoin('customer', 'customer.id', '=', 'sales_order_header.customer_id')
				->leftjoin('item_stock', 'item_stock.id', '=', 'sales_order_line.item_stock_id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $request->date_end])
				->where("sales_order_header.customer_id", "=", $request->customer)
				->where("item_stock.id", "=", $request->item_stock)
				->orderby("sales_order_header.createdOn", "asc")
				->get();
			$datacustomer = Customer::find($request->customer);
			return view('report.perbarangkonsumen', [
				"data" => $data,
				"start" => $request->date_start,
				"end" => $date_end,
				"customer" => $datacustomer,
				"lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi
			]);
		} elseif ($request->has("customer") && $request->has("detailbarang")) {
			$data = SalesOrderLine::select("*", "customer.name as customername", "sales_order_line.qty as beli", "sales_order_header.createdOn as tanggalorder")
				->leftjoin('sales_order_header', 'sales_order_header.id', '=', 'sales_order_line.sales_order_header_id')
				->leftjoin('customer', 'customer.id', '=', 'sales_order_header.customer_id')
				->leftjoin('item_stock', 'item_stock.id', '=', 'sales_order_line.item_stock_id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $request->date_end])
				->where("sales_order_header.customer_id", "=", $request->customer)
				->orderby("sales_order_header.createdOn", "asc")
				->get();
			$datacustomer = Customer::find($request->customer);
			return view('report.perbarangkonsumen', [
				"data" => $data,
				"start" => $request->date_start,
				"end" => $date_end,
				"filter" => True,
				"customer" => $datacustomer,
				"lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi
			]);
		} else if ($request->has("customer")) {
			// $response = $this->client->get($this->base_uri("sales_order_header/c/" . $request->date_start . "/" . $tglkirim . "/" . $request->customer));
			// $hasil = json_decode($response->getBody()->getContents());
			// $data = $hasil->data;
			$data = SalesOrderHeader::with("customer", "detail")->whereBetween('sales_order_header.createdOn', [$request->date_start, $tglkirim])->where("customer_id", "=", $request->customer)->get();

			$name = "Laporan/Penjualan/Laporan Penjualan per-" . Date("YmdHis") . ".pdf";
			$datacustomer = Customer::find($request->customer);
			return view('report.penjualan-ringkasan', ["data" => $data, "start" => $request->date_start, "end" => $date_end, "customer" => $datacustomer, "lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi]);
		} else if ($request->has("sales")) {
			// $response = $this->client->get($this->base_uri("sales_order_header/s/" . $request->date_start . "/" . $tglkirim . "/" . $request->sales));
			// $hasil = json_decode($response->getBody()->getContents());
			// $data = $hasil->data;
			// dd($request->date_start);
			$data = SalesOrderHeader::with("customer", "detail")
				->select("sales_order_header.*")
				->join("customer", "customer.id", "=", "sales_order_header.customer_id")
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $tglkirim])
				->where("sales_id", "=", $request->sales)
				->orderby("sales_order_header.createdOn", "asc")
				->get();
			// dd($data);
			$name = "Laporan/Penjualan/Laporan Penjualan per-" . Date("YmdHis") . ".pdf";
			$datasales = User::find($request->sales);
			return view('report.penjualan-ringkasan', ["data" => $data, "start" => $request->date_start, "end" => $date_end, "namasales" => $datasales, "lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi]);
		} else if ($request->has("item_stock")) {
			$data = SalesOrderLine::select("*", "customer.name as customername", "sales_order_line.qty as beli", "sales_order_header.createdOn as tanggalorder")
				->leftjoin('sales_order_header', 'sales_order_header.id', '=', 'sales_order_line.sales_order_header_id')
				->leftjoin('customer', 'customer.id', '=', 'sales_order_header.customer_id')
				->leftjoin('item_stock', 'item_stock.id', '=', 'sales_order_line.item_stock_id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $request->date_end])
				->where("item_stock.id", "=", $request->item_stock)
				->orderby("sales_order_header.createdOn", "asc")
				->get();

			return view('report.perbarangkonsumen', [
				"data" => $data,
				"start" => $request->date_start,
				"end" => $date_end,
				"lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi
			]);
		} else {
			// $response = $this->client->get($this->base_uri("sales_order_header/" . $request->date_start . "/" . $tglkirim));
			// $hasil = json_decode($response->getBody()->getContents());
			$data = SalesOrderHeader::with("customer", "detail.stock.inventoryproperty.item")
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $tglkirim])->get();
			$name = "Laporan/Penjualan/Laporan Penjualan per-" . Date("YmdHis") . ".pdf";
			return view('report.penjualan-ringkasan', ["data" => $data, "start" => $request->date_start, "end" => $date_end, "lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi]);
		}

		return redirect()->back();
	}

	public function getlaporanreturpembelian(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$d["start"] = $request->date_start;
		$d["end"] = $request->date_end;
		if ($request->has("item_stock") && ($request->has("supplier"))) {

			$item_id = ItemStock::find($request->item_stock);
			$d['item'] = $item_id->inventoryproperty->item->item_name;
			$supplier = Supplier::find($request->supplier);
			$d['supplier'] = $supplier->supplier_name;

			$d['data'] = SupplierReturnHeader::with("supplier", "detail.stock.item")
				->select("supplier_return_header.*")
				->leftjoin('supplier_return_line', 'supplier_return_line.supplier_return_header_id', '=', 'supplier_return_header.id')
				->leftjoin('item_stock', 'item_stock.id', '=', 'supplier_return_line.item_stock_id')
				// ->leftjoin('item_stock', 'item_stock.item_id', '=', 'inventory_property.id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('supplier_return_header.createdOn', [$request->date_start, $request->date_end])
				->where("supplier_return_line.item_id", "=", $item_id->item_id)
				->where("supplier_return_header.supplier_code", "=", $request->supplier)
				->get();
		} else if ($request->has("supplier")) {
			$supplier = Supplier::find($request->supplier);
			$d['supplier'] = $supplier->supplier_name;

			$d['data'] = SupplierReturnHeader::with("supplier", "detail.stock.item")
				->whereBetween('supplier_return_header.createdOn', [$request->date_start, $request->date_end])
				->where("supplier_code", "=", $request->supplier)
				->get();
		} else if ($request->has("item_stock")) {
			$item_id = ItemStock::find($request->item_stock);
			$d['item'] = $item_id->inventoryproperty->item->item_name;

			$d['data'] = SupplierReturnHeader::with("supplier", "detail.stock.item")
				->select("supplier_return_header.*")
				->leftjoin('supplier_return_line', 'supplier_return_line.supplier_return_header_id', '=', 'supplier_return_header.id')
				->leftjoin('item_stock', 'item_stock.id', '=', 'supplier_return_line.item_stock_id')
				// ->leftjoin('item_stock', 'item_stock.item_id', '=', 'inventory_property.id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('supplier_return_header.createdOn', [$request->date_start, $request->date_end])
				->where("supplier_return_line.item_id", "=", $item_id->item_id)
				// ->where("supplier_return_header.supplier_code","=",$request->supplier)
				->get();
		} else {
			$d['data'] = SupplierReturnHeader::with("supplier", "detail.stock.item")
				->whereBetween('supplier_return_header.createdOn', [$request->date_start, $request->date_end])
				->get();
		}
		$d["detail"] = true;

		return view('report.return-pembelian', $d);
	}

	public function getlaporanreturpenjualan(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$d["start"] = $request->date_start;
		$d["end"] = $request->date_end;
		if ($request->has("item_stock") && ($request->has("customer"))) {
			$item_id = ItemStock::find($request->item_stock);
			$d['item'] = $item_id->inventoryproperty->item->item_name;

			$d['data'] = CustomerReturnHeader::with("customer", "detail.stock.inventoryproperty.item")
				->select("customer_return_header.*")
				->leftjoin('customer_return_line', 'customer_return_line.customer_return_header_id', '=', 'customer_return_header.id')
				->leftjoin('item_stock', 'item_stock.id', '=', 'customer_return_line.item_stock_id')
				// ->leftjoin('item_stock', 'item_stock.item_id', '=', 'inventory_property.id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('customer_return_header.createdOn', [$request->date_start, $request->date_end])
				->where("customer_return_line.item_stock_id", "=", $request->item_stock)
				->where("customer_return_header.customer_id", "=", $request->customer)
				->get();
		} else if ($request->has("customer")) {
			$customer = Customer::find($request->customer);
			$d['customer'] = $customer->name;
			$d['data'] = CustomerReturnHeader::with("customer", "detail.stock.inventoryproperty.item")
				->whereBetween('customer_return_header.createdOn', [$request->date_start, $request->date_end])
				->where("customer_id", "=", $request->customer)
				->get();
		} else if ($request->has("item_stock")) {
			$item_id = ItemStock::find($request->item_stock);
			$d['item'] = $item_id->inventoryproperty->item->item_name;

			$d['data'] = CustomerReturnHeader::with("customer", "detail.stock.inventoryproperty.item")
				->select("customer_return_header.*")
				->leftjoin('customer_return_line', 'customer_return_line.customer_return_header_id', '=', 'customer_return_header.id')
				->leftjoin('item_stock', 'item_stock.id', '=', 'customer_return_line.item_stock_id')
				// ->leftjoin('item_stock', 'item_stock.item_id', '=', 'inventory_property.id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'item_stock.item_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('customer_return_header.createdOn', [$request->date_start, $request->date_end])
				->where("customer_return_line.item_stock_id", "=", $request->item_stock)
				// ->where("customer_return_header.customer_id","=",$request->customer)
				->get();
		} else {
			$d['data'] = CustomerReturnHeader::with("customer", "detail.stock.inventoryproperty.item")
				->whereBetween('customer_return_header.createdOn', [$request->date_start, $request->date_end])
				->get();
		}
		$d["detail"] = true;
		return view('report.return-penjualan', $d);
	}

	public function getlaporankomisi(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$data;
		$datasales;
		$datacustomer;
		$tglkirim = date("Y-m-d", strtotime($request->date_end . "+1 days"));
		if ($request->has("customer")) {
			// $response = $this->client->get($this->base_uri("sales_order_header/c/" . $request->date_start . "/" . $tglkirim . "/" . $request->customer));
			// $hasil = json_decode($response->getBody()->getContents());
			// $data = $hasil->data;

			$data = SalesOrderHeader::with("customer.sales", "detail")
				->select("sales_order_header.*")
				->where("customer_id", "=", $request->customer)
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $tglkirim])
				->orderby("sales_order_header.createdOn", "desc")
				->get();

			$name = "Laporan/Penjualan/Laporan Penjualan per-" . Date("YmdHis") . ".pdf";

			$customer = Customer::find($request->customer);
			// $response = $this->client->get($this->base_uri("customer/" . $request->customer));
			// $hasilcustomer = json_decode($response->getBody()->getContents());
			// $datacustomer = $hasilcustomer->data;
			return view('report.komisi', ["customer" => $customer, "data" => $data, "start" => $request->date_start, "end" => $request->date_end, "lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi]);
		} else if ($request->has("sales")) {
			// $response = $this->client->get($this->base_uri("sales_order_header/s/" . $request->date_start . "/" . $tglkirim . "/" . $request->sales));
			// $hasil = json_decode($response->getBody()->getContents());
			// $data = $hasil->data;
			$data = SalesOrderHeader::with("customer.sales", "detail")
				->select("sales_order_header.*")
				->join("customer", "customer.id", "=", "sales_order_header.customer_id")
				->join("user", "user.id", "=", "customer.sales_id")
				->where("user.id", "=", $request->sales)
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $tglkirim])
				->orderby("sales_order_header.createdOn", "desc")
				->get();
			$name = "Laporan/Penjualan/Laporan Penjualan per-" . Date("YmdHis") . ".pdf";
			// $response = $this->client->get($this->base_uri("users/" . $request->sales));
			// $hasilsales = json_decode($response->getBody()->getContents());
			// $datasales = $hasilsales->data;
			$sales = User::find($request->sales);
			return view('report.komisi', ["sales" => $sales, "data" => $data, "start" => $request->date_start, "end" => $request->date_end, "lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi]);
		} else {
			// $response = $this->client->get($this->base_uri("sales_order_header/" . $request->date_start . "/" . $tglkirim));
			// $hasil = json_decode($response->getBody()->getContents());
			// $data = $hasil->data;
			$data = SalesOrderHeader::with("customer.sales", "detail")
				->select("sales_order_header.*")
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $tglkirim])
				->orderby("sales_order_header.createdOn", "desc")
				->get();
			$name = "Laporan/Penjualan/Laporan Penjualan per-" . Date("YmdHis") . ".pdf";
			return view('report.komisi', ["data" => $data, "start" => $request->date_start, "end" => $request->date_end, "lihatkomisi" => $request->lihatkomisi, "lihatsemuakomisi" => $request->semuakomisi]);
		}

		return redirect()->back();
	}

	public function getlaporanpembelian(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$date_end = date("Y-m-d", strtotime($request->date_end . "+1 days"));
		if ($request->has("supplier") && $request->has("itemstock")) {
			$data = PurchaseInvoiceLine::select("*", "purchase_invoice_line.qty as beli", "purchase_invoice_line.price_per_satuan_id as hargabeli", "purchase_invoice_header.invoice_date as tglbeli")
				->leftjoin('po_line', 'po_line.id', '=', 'purchase_invoice_line.po_line_id')
				->leftjoin('po_header', 'po_header.id', '=', 'po_line.po_header_id')
				->leftjoin('purchase_invoice_header', 'purchase_invoice_header.poheader_id', '=', 'po_header.id')
				->leftjoin('supplier', 'supplier.id', '=', 'po_header.supplier_id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'po_line.inventory_property_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('purchase_invoice_header.invoice_date', [$request->date_start, $date_end])
				->where("purchase_invoice_line.qty", ">", 0)
				->where("po_line.inventory_property_id", "=", $request->itemstock)
				->where("supplier.id", "=", $request->supplier)
				->orderby("purchase_invoice_header.invoice_date", "asc")
				->get();
			return view('report.perbarangsupplier', [
				"data" => $data,
				"start" => $request->date_start,
				"end" => $date_end,
			]);
		} else if ($request->has("supplier")) {
			$data;
			$view;
			if ($request->has("detail_supplier")) {

				$data = PurchaseInvoiceLine::select("*", "purchase_invoice_line.qty as beli", "purchase_invoice_line.price_per_satuan_id as hargabeli", "purchase_invoice_header.invoice_date as tglbeli")
					->leftjoin('po_line', 'po_line.id', '=', 'purchase_invoice_line.po_line_id')
					->leftjoin('po_header', 'po_header.id', '=', 'po_line.po_header_id')
					->leftjoin('purchase_invoice_header', 'purchase_invoice_header.poheader_id', '=', 'po_header.id')
					->leftjoin('supplier', 'supplier.id', '=', 'po_header.supplier_id')
					->leftjoin('inventory_property', 'inventory_property.id', '=', 'po_line.inventory_property_id')
					->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
					->whereBetween('purchase_invoice_header.invoice_date', [$request->date_start, $date_end])
					->where("purchase_invoice_line.qty", ">", 0)
					->where("supplier.id", "=", $request->supplier)
					->orderby("purchase_invoice_header.invoice_date", "asc")
					->get();

				$view = "report.perbarangsupplier";
			} else {
				$data = PurchaseInvoiceHeader::select("*", "purchase_invoice_header.invoice_date as tgl")
					->join('po_header', 'po_header.id', '=', 'purchase_invoice_header.poheader_id')
					->join('supplier', 'supplier.id', '=', 'po_header.supplier_id')
					->whereBetween('purchase_invoice_header.invoice_date', [$request->date_start, $date_end])
					->where("supplier.id", "=", $request->supplier)
					->orderby("purchase_invoice_header.invoice_date", "asc")
					->get();
				$view = "report.pembelian-ringkasan";
			}
			return view($view, ["data" => $data, "start" => $request->date_start, "end" => $date_end, "s" => false]);
		} else if ($request->has("itemstock")) {
			$data = PurchaseInvoiceLine::select("*", "purchase_invoice_line.qty as beli", "purchase_invoice_line.price_per_satuan_id as hargabeli", "purchase_invoice_header.invoice_date as tglbeli")
				->leftjoin('po_line', 'po_line.id', '=', 'purchase_invoice_line.po_line_id')
				->leftjoin('po_header', 'po_header.id', '=', 'po_line.po_header_id')
				->leftjoin('purchase_invoice_header', 'purchase_invoice_header.poheader_id', '=', 'po_header.id')
				->leftjoin('supplier', 'supplier.id', '=', 'po_header.supplier_id')
				->leftjoin('inventory_property', 'inventory_property.id', '=', 'po_line.inventory_property_id')
				->leftjoin('item', 'item.id', '=', 'inventory_property.item_id')
				->whereBetween('purchase_invoice_header.invoice_date', [$request->date_start, $date_end])
				->where("purchase_invoice_line.qty", ">", 0)
				->where("po_line.inventory_property_id", "=", $request->itemstock)
				->orderby("purchase_invoice_header.invoice_date", "asc")
				->get();
			return view('report.perbarangsupplier', [
				"data" => $data,
				"start" => $request->date_start,
				"end" => $date_end,
			]);
		} else {
			$data = PurchaseInvoiceHeader::select("*", "purchase_invoice_header.invoice_date as tgl")
				->join('po_header', 'po_header.id', '=', 'purchase_invoice_header.poheader_id')
				->join('supplier', 'supplier.id', '=', 'po_header.supplier_id')
				->whereBetween('purchase_invoice_header.invoice_date', [$request->date_start, $date_end])
				->orderby("purchase_invoice_header.invoice_date", "asc")
				->get();
			return view('report.pembelian-ringkasan', ["data" => $data, "start" => $request->date_start, "end" => $date_end]);
		}

		return redirect()->back();
	}

	public function getlaporanpiutang(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}

		$filter ="";

		$request->date_end = date("Y-m-d", strtotime($request->date_end . "+1 days"));

		if ($request->has("customer")) {
			$data = SalesOrderHeader::select(DB::raw('`customer`.`name`,SUM(`total_sales`) as "totalsales", SUM(`payment_remain`) as "payment_remain",SUM(`total_paid`) as "totalpaid",sum(`retur`) as "retur",sum(`diskon`) as "diskon"'))
				->join('customer', 'customer.id', '=', 'sales_order_header.customer_id')
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $request->date_end])
				->where('customer.id', '=', $request->customer);

			if ($request->has("lunas")) {
				$data = $data->havingRaw('SUM(payment_remain) = ?', [0]);
				$filter = "Lunas";
			} else if ($request->has("belumlunas")) {
				$data = $data->havingRaw('SUM(payment_remain) > ?', [0]);
				$filter = "Belum Lunas";
			}
			$data = $data->groupBy('customer.name')
				->orderby("sales_order_header.createdOn", "asc")
				->get();

			$name = "Laporan/Piutang/Laporan Piutang per-" . Date("YmdHis") . ".pdf";

			return view('report.piutang', [
				"data" => $data,
				"tanggalstart" => $request->date_start,
				"tanggalend" => $request->date_end,
				"filter" => $filter

			]);
		} else if ($request->has("sales")) {
			$data = SalesOrderHeader::select(DB::raw('`customer`.`name`,SUM(`total_sales`) as "totalsales", SUM(`payment_remain`) as "payment_remain",SUM(`total_paid`) as "totalpaid",sum(`retur`) as "retur",sum(`diskon`) as "diskon"'))
				->join('customer', 'customer.id', '=', 'sales_order_header.customer_id')
				->join('user', 'user.id', '=', 'customer.sales_id')
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $request->date_end])
				->where('customer.sales_id', '=', $request->sales);

				if ($request->has("lunas")) {
				$data = $data->havingRaw('SUM(payment_remain) = ?', [0]);
				$filter = "Lunas";
			} else if ($request->has("belumlunas")) {
				$data = $data->havingRaw('SUM(payment_remain) > ?', [0]);
				$filter = "Belum Lunas";
			}
			$data = $data->groupBy('customer.name')
				->orderby("sales_order_header.createdOn", "asc")
				->get();

			$user = User::where("id", "=", $request->sales)->first();

			$name = "Laporan/Piutang/Laporan Piutang per-" . Date("YmdHis") . ".pdf";
			return view('report.piutang', [
				"data" => $data,
				"user" => $user,
				"tanggalstart" => $request->date_start,
				"tanggalend" => $request->date_end,
				"filter" => $filter

			]);
		} else {

			$data = SalesOrderHeader::select(DB::raw('`customer`.`name`,SUM(`total_sales`) as "totalsales", SUM(`payment_remain`) as "payment_remain",SUM(`total_paid`) as "totalpaid",sum(`retur`) as "retur",sum(`diskon`) as "diskon"'))
				->join('customer', 'customer.id', '=', 'sales_order_header.customer_id')
				->whereBetween('sales_order_header.createdOn', [$request->date_start, $request->date_end]);
				if ($request->has("lunas")) {
				$data = $data->havingRaw('SUM(payment_remain) = ?', [0]);
				$filter = "Lunas";
			} else if ($request->has("belumlunas")) {
				$data = $data->havingRaw('SUM(payment_remain) > ?', [0]);
				$filter = "Belum Lunas";
			}

				$data = $data->groupBy('customer.name')
				->orderby("sales_order_header.createdOn", "asc")
				->get();

			$name = "Laporan/Piutang/Laporan Piutang per-" . Date("YmdHis") . ".pdf";

			return view('report.piutang', [
				"data" => $data,
				"tanggalstart" => $request->date_start,
				"tanggalend" => $request->date_end,
				"filter" => $filter
			]);
		}
		return redirect()->back();
	}

	public function getlaporanpengeluaran(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$date_end = date("Y-m-d", strtotime($request->date_end . "+1 days"));
		$query;
		if ($request->has("pegawai")) {
			$query = Pengeluaran::select("pengeluaran.*", "user.displayName", "inventoris.name", "kategori_pengeluaran.name as ktname")->join("kategori_pengeluaran", "kategori_pengeluaran.id", "=", "pengeluaran.kategori_pengeluaran_id")->leftjoin("inventoris", "inventoris.id", "=", "pengeluaran.inventaris_id")->leftjoin("user", "user.id", "=", "pengeluaran.user_id")->where("user_id", "=", $request->pegawai)->whereBetween('pengeluaran.tanggal', [$request->date_start, $date_end]);
		} else if ($request->has("inventaris")) {
			$query = Pengeluaran::select("pengeluaran.*", "user.displayName", "inventoris.name", "kategori_pengeluaran.name as ktname")->join("kategori_pengeluaran", "kategori_pengeluaran.id", "=", "pengeluaran.kategori_pengeluaran_id")->leftjoin("inventoris", "inventoris.id", "=", "pengeluaran.inventaris_id")->leftjoin("user", "user.id", "=", "pengeluaran.user_id")->where("inventaris_id", "=", $request->inventaris)->whereBetween('pengeluaran.tanggal', [$request->date_start, $date_end]);
		} else {

			$query = Pengeluaran::select("pengeluaran.*", "user.displayName", "inventoris.name", "kategori_pengeluaran.name as ktname")->join("kategori_pengeluaran", "kategori_pengeluaran.id", "=", "pengeluaran.kategori_pengeluaran_id")->leftjoin("inventoris", "inventoris.id", "=", "pengeluaran.inventaris_id")->leftjoin("user", "user.id", "=", "pengeluaran.user_id")->whereBetween('pengeluaran.tanggal', [$request->date_start, $date_end]);
		}

		if ($request->has("kategori_pengeluaran_id")) {
			$query = $query->where("kategori_pengeluaran_id", "=", $request->kategori_pengeluaran_id);
		}
		$query = $query->orderby("pengeluaran.tanggal", "asc")->get();
		$name = "Laporan/Pengeluaran/Laporan Pengeluaran per-" . Date("YmdHis") . ".pdf";
		return view('report.pengeluaran-ringkasan', [
			"data" => $query,
			"tanggalstart" => $request->date_start,
			"tanggalend" => $request->date_end,
		]);
	}

	
	public function getlaporanhutang(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}

		if ($request->has("supplier")) {
			$data = PurchaseInvoiceHeader::select(DB::raw('`supplier`.`supplier_name`,SUM(`invoice_total`) as "invoice_total",SUM(`paid_total`) as "paid_total",sum(`retur`) as "retur"'))
				->join('po_header', 'po_header.id', '=', 'purchase_invoice_header.poheader_id')
				->join('supplier', 'supplier.id', '=', 'po_header.supplier_id')
				->whereBetween('purchase_invoice_header.invoice_date', [$request->date_start, $request->date_end])
				->where('supplier.id', '=', $request->supplier)
				->groupBy('supplier.supplier_name')
				->orderby("purchase_invoice_header.invoice_date", "asc")
				->get();


			return view('report.hutang', [
				"data" => $data,
				"tanggalstart" => $request->date_start,
				"tanggalend" => $request->date_end,
			]);
		} else {
			$data = PurchaseInvoiceHeader::select(DB::raw('`supplier`.`supplier_name`,SUM(`invoice_total`) as "invoice_total",SUM(`paid_total`) as "paid_total",sum(`retur`) as "retur"'))
				->join('po_header', 'po_header.id', '=', 'purchase_invoice_header.poheader_id')
				->join('supplier', 'supplier.id', '=', 'po_header.supplier_id')
				->whereBetween('purchase_invoice_header.invoice_date', [$request->date_start, $request->date_end])
				->groupBy('supplier.supplier_name')
				->orderby("purchase_invoice_header.invoice_date", "asc")
				->get();


			return view('report.hutang', [
				"data" => $data,
				"tanggalstart" => $request->date_start,
				"tanggalend" => $request->date_end,
			]);
		}
		return redirect()->back();
	}

	public function getringkasankomisi(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$response = $this->client->get($this->base_uri("komisi/" . $request->sales . "/" . $request->date_start . "/" . $request->date_end));
		$response2 = $this->client->get($this->base_uri("users/" . $request->sales));

		$hasil = json_decode($response->getBody()->getContents());
		$hasil2 = json_decode($response2->getBody()->getContents());
		$datad = $hasil2->data;
		$data = $hasil->data;
		$name = "Laporan/Komisi/Laporan Komisi per-" . Date("YmdHis") . ".pdf";
		return view('report.komisi', ["data" => $hasil->data, "datas" => $datad]);
		// $printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName hp1 $name";
		// exec($printcmd);

		return redirect()->back();
	}

	public function getringkasankas(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$response = $this->client->get($this->base_uri("bank_cash_transaction/" . $request->sales . "/" . $request->date_start . "/" . $request->date_end));
		$hasil = json_decode($response->getBody()->getContents());
		$data = $hasil->data;
		$name = "Laporan/Kas/Laporan Kas per-" . Date("YmdHis") . ".pdf";
		return view('report.kas', ["data" => $hasil->data]);
		// $printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName hp1 $name";
		return redirect()->back();
	}

	public function getringkasanlabarugi(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
	}

	public function getringkasanneraca(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$response1 = $this->client->get($this->base_uri("bank_cash"));
		$hasilbank = json_decode($response1->getBody()->getContents());

		$response2 = $this->client->get($this->base_uri("item_stock"));
		$hasilitemstock = json_decode($response2->getBody()->getContents());

		$response3 = $this->client->get($this->base_uri("sales_order_header/" . $request->date_start . "/" . $request->date_end));
		$hasilpiutang = json_decode($response3->getBody()->getContents());

		$response4 = $this->client->get($this->base_uri("po_header_hutang/" . date('m-01-Y') . "/" . date('m-t-Y')));
		$hasilutang = json_decode($response4->getBody()->getContents());

		return view('report.neraca', [
			"stock" => $hasilitemstock->data,
			"bank" => $hasilbank->data,
			"piutang" => $hasilpiutang->data,
			"utang" => $hasilutang->data
		], [], [
			'format' => 'letter'
		]);
		// return $pdf->stream('Laporan Neraca per ' . date("Y-m-d H:i:s") . '.pdf', array('Attachment' => 0));
	}

	public function getdetailstock(Request $request)
	{
		$response = $this->client->get($this->base_uri("stock_mutation/item_stock/" . $request->date_start . "/" . $request->date_end));
		$hasil = json_decode($response->getBody()->getContents());
		return view(
			'report.item_stock-detail',
			[
				"data" => $hasil->data
			]
		);
		// return $pdf->stream('Laporan Persediaan Barang Lengkap per ' . date("Y-m-d H:i:s") . '.pdf', array('Attachment' => 0));
	}

	public function getdetailpenjualan(Request $request)
	{
		$response = $this->client->get($this->base_uri("sales_invoice_header/" . $request->date_start . "/" . $request->date_end));
		$hasil = json_decode($response->getBody()->getContents());
		$line = (object) array();
		for ($i = 0; $i < count($hasil->data); $i++) {
			$response = $this->client->get($this->base_uri("sales_invoice_line/detail/" . $hasil->data[$i]->id));
			$hasil2 = json_decode($response->getBody()->getContents());
			$id = "id" . $hasil->data[$i]->id;
			$line->$id = $hasil2;
		}
		return view('report.penjualan-detail', [
			"data" => $hasil->data,
			"line" => $line,
		]);
		// return $pdf->stream('Laporan Penjualan per '.date("Y-m-d H:i:s").'.pdf');
	}

	public function getdetailpembelian(Request $request)
	{
		$response = $this->client->get($this->base_uri("purchase_invoice_header/" . $request->date_start . "/" . $request->date_end));
		$hasil = json_decode($response->getBody()->getContents());
		$line = (object) array();
		for ($i = 0; $i < count($hasil->data); $i++) {
			$response = $this->client->get($this->base_uri("purchase_invoice_line/detail/" . $hasil->data[$i]->id));
			$hasil2 = json_decode($response->getBody()->getContents());
			$id = "id" . $hasil->data[$i]->id;
			$line->$id = $hasil2;
		}
		return view('report.pembelian-detail', [
			"data" => $hasil->data,
			"line" => $line,
		]);
		// return $pdf->stream('Laporan Pembelian per '.date("Y-m-d H:i:s").'.pdf');
	}

	public function getdetailkomisi(Request $request)
	{
		$response = $this->client->get($this->base_uri("komisi/" . $request->sales . "/" . $request->date_start . "/" . $request->date_end));
		$hasil = json_decode($response->getBody()->getContents());
		return view('report.komisi', [
			"data" => $hasil->data
		], [], [
			'format' => 'letter'
		]);
		// return $pdf->stream('Laporan Komisi per ' . date("Y-m-d H:i:s") . '.pdf', array('Attachment' => 0));
	}

	public function getdetailkas(Request $request)
	{ }

	public function getlaporanlabarugi(Request $request)
	{
		if ($request->date_start == null) {
			$request->date_start = "1900-01-01";
		}
		if ($request->date_end == null) {
			$request->date_end = date("Y-m-d");
		}
		$datapenjualan = DB::table('sales_order_header')
			->select(DB::raw('SUM(`total_sales`) as "totalsales", SUM(`payment_remain`) as "paymentremain",SUM(`total_paid`) as "totalpaid",sum(`retur`) as "retur",sum(`modal`) as "modal"'))
			->join('customer', 'customer.id', '=', 'sales_order_header.customer_id')
			->whereBetween('sales_order_header.createdOn', [$request->date_start, $request->date_end])
			->first();

		$datapembelian = DB::table('purchase_invoice_header')
			->select(DB::raw('SUM(`invoice_total`) as "invoice_total",SUM(`paid_total`) as "paid_total",sum(`retur`) as "retur"'))
			->join('po_header', 'po_header.id', '=', 'purchase_invoice_header.poheader_id')
			->join('supplier', 'supplier.id', '=', 'po_header.supplier_id')
			->whereBetween('purchase_invoice_header.createdOn', [$request->date_start, $request->date_end])
			->first();

		$datapengeluaran = DB::table('pengeluaran')
			->select(DB::raw('SUM(`jumlah`) as "totalpengeluaran"'))
			->whereBetween('pengeluaran.tanggal', [$request->date_start, $request->date_end])
			->first();

		return view('report.labarugi', [
			"datapenjualan" => $datapenjualan,
			"datapembelian" => $datapembelian,
			"datapengeluaran" => $datapengeluaran,
			"tanggalstart" => $request->date_start,
			"tanggalend" => $request->date_end,
		]);
	}

	public function getdetailneraca(Request $request)
	{ }

	public function printfakturpenjualan($id)
	{
		$header = View::make('report.header');
		$response = $this->get("customer-shipment-header/detail/" . $id);
		$name = "Laporan/Faktur/" . 'faktur-' . $id . "" . date("Y-m-dh-i-s") . '.pdf';
		$pdf = PDF::loadView('report.penjualan-faktur', [
			"supir" => $response["data"]->supir,
			"kenek" => $response["data"]->kenek,
			"line" => $response["data"]->sales->detail,
			"data" => $response["data"]->sales,
		])
			->setOption('page-height', '165')
			->setOption('page-width', '215')
			->setOption('margin-bottom', '0')

			// ->setPaper([0, 0, 609.4488, 467.7165], 'portrait')
			// ->setOption('header-html', $header)165, 215
			->save($name);
		$printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName 'EPSON LX-310 ESC/P' $name";
		exec($printcmd);
		echo $name;

		$ray = array();
		$ray["print"] = 1;
		$response3 = $this->put("sales-order-header/$id", $ray);
	}

	public function printfakturreturpenjualan($id)
	{

		// $response = $this->client->get($this->base_uri("customer_return_line/" . $id));
		// $hasil2 = json_decode($response->getBody()->getContents());
		// $response = $this->client->get($this->base_uri("credit_memo_settlement/detail/" . $id));
		// $hasil = json_decode($response->getBody()->getContents());

		// $name = "Laporan/ReturFaktur/Penjualan/" . 'Rfaktur-' . $id . "" . date("Y-m-dh-i-s") . '.pdf';
		// $pdf = PDF::loadView('report.retur-faktur-penjualan', [
		// 	"data" => $hasil->data,
		// 	"line" => $hasil2->data,
		// ])
		// 	->setOption('page-height', '165')
		// 	->setOption('page-width', '215')
		// 	->save($name);
		// $printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName 'EPSON LX-310 ESC/P' $name";
		// exec($printcmd);
		// echo $name;
		$response = $this->get("customer-return-header/" . $id);
		$name = "Laporan/ReturFaktur/Penjualan/" . 'Rfaktur-' . $id . "" . date("Y-m-dh-i-s") . '.pdf';
		$pdf = PDF::loadView('report.retur-faktur-penjualan', [
			"data" => $response["data"],
			"line" => $response["data"]->detail,
		])->setOption('page-height', '185')->setOption('page-width', '215')->save($name);
		$printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName 'EPSON LX-310 ESC/P' $name";
		exec($printcmd);
		echo $name;
	}

	public function printpo($id)
	{
		$response = $this->getData("po-header/$id/detail");
		$name = "Laporan/Faktur/PO/" . 'PO-' . $id . " " . date("Y-m-d h-i-s") . '.pdf';
		$pdf = PDF::loadView('report.faktur-po', [
			"data" => $response,
			"line" => $response->line,
		])->setPaper('a4')->setOrientation('landscape')->save($name);
		$printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName lx $name";
		exec($printcmd);
	}

	public function printfakturreturpembelian($id)
	{
		// 	$response = $this->client->get($this->base_uri("debit_memo_settlement/detail/" . "/$id"));
		// 	$hasil = json_decode($response->getBody()->getContents());
		$response = $this->get("supplier-return-header/" . $id);

		$name = "Laporan/ReturFaktur/Pembelian/" . 'Rfaktur-' . $id . "" . date("Y-m-dh-i-s") . '.pdf';
		$pdf = PDF::loadView('report.retur-faktur-pembelian', [
			"data" => $response["data"],
			"line" => $response["data"]->detail,
		])->setOption('page-height', '165')->setOption('page-width', '215')->save($name);
		$printcmd = "java -classpath pdfbox-app-1.7.1.jar org.apache.pdfbox.PrintPDF -silentPrint -printerName 'EPSON LX-310 ESC/P' $name";
		exec($printcmd);
		echo $name;
	}

	public function printtojava($id)
	{
		$response = $this->client->get($this->base_uri("print/faktur-" . $id));
	}

	public function getPDF(Request $request, $id)
	{
		$student = Student::findOrFail($id);
		$pdf = PDF::loadView('pdf.result', ['student' => $student]);
		return $pdf->stream('result.pdf', array('Attachment' => 0));
	}
}
