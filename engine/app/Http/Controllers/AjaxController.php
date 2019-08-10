<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
	public function getReturnSupplierHistory($invenid, $supplierid)
	{
		$response = $this->getData("po-line/$invenid/$supplierid/history");
		return response()->json($response);
	}
	public function getAllConsumer(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("customer/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("customer");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function searchConsumer($id)
	{
		$response = $this->client()->get("customer/$id");
		$data = json_decode($response->getBody())->data;
		return response()->json($data);
	}

	public function sumConsumerHutang($id)
	{
		$response = $this->client()->get("sales-order-header/$id/hutang");
		$data = json_decode($response->getBody())->data;
		return response()->json($data);
	}

	public function detailConsumerHutang($id)
	{
		$response = $this->client()->get("sales-order-header/$id/riwayat");
		$data = json_decode($response->getBody())->data;
		return response()->json($data);
	}

	public function detailConsumerHutangById($id)
	{
		return response()->json($this->get("sales-order-header/$id/hutang/id"));
	}

	public function getAllStock(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("item-stock/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
		return response()->json([]);
	}

	public function getAllStockDataTable(Request $request)
	{
		$response = $this->client()->get("item-stock/datatable", [
			"json" => $request->all()
		]);
		$hasil = json_decode($response->getBody())->data->data;
		return response()->json($hasil);
	}

	public function searchStock($id)
	{
		$response = $this->client()->get("item-stock/$id");
		$hasil = json_decode($response->getBody());
		return response()->json($hasil->data);
	}

	public function getAllSales()
	{
		$response = $this->client()->get("sales-order-header");
		$hasil = json_decode($response->getBody());
		return response()->json($hasil->data);
	}

	public function getSearchSalesByCustomer(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("sales-order-header/" . $request->q . "/riwayat");
			$hasil = json_decode($response->getBody());
			return response()->json($hasil->data);
		} else {
			$response = $this->client()->get("sales-order-header/piutang");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function getSearchSalesByCustomerID(Request $request, $customer_id)
	{
		if ($request->has("q")) {
			$response = $this->get("sales-order-header/" . $customer_id . "/customer/" . $request->q);
			$hasil = $response["data"];
			return response()->json($hasil->data);
		} else {
			$response = $this->get("sales-order-header/" . $customer_id . "/customer");
			$hasil = $response["data"];
			return response()->json($hasil->data);
		}
	}


	public function searchSalesById($id)
	{
		$response = $this->client()->get("sales-order-header/$id");
		$hasil = json_decode($response->getBody());
		return response()->json($hasil->data);
	}

	public function searchSalesByCustomer($id)
	{
		$response = $this->client()->get("sales-order-header/$id/customer");
		$hasil = json_decode($response->getBody());
		return response()->json($hasil->data);
	}

	public function getAllBrand(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("brand/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("brand/");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function getAllCategory(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("category/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("category/");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}
	public function getAllInven(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("inventory-property/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("inventory-property");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function searchSatuanStock($id)
	{
		$response = $this->client()->get("item-stock/inven/$id");
		$hasil = json_decode($response->getBody());
		return response()->json($hasil->data);
	}

	public function getAllGudang(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("warehouse/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("warehouse");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function getAllSatuan(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("satuan/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("satuan");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function getAllCity(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("city/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("city");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}


	public function getAllSalesman(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("user/sales/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("user/sales");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function getAllRole(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("role/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("role");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}
	public function getAllSupplier(Request $request)
	{
		if ($request->has("q")) {
			$response = $this->client()->get("supplier/" . $request->q . "/search");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		} else {
			$response = $this->client()->get("supplier");
			$hasil = json_decode($response->getBody())->data;
			return response()->json($hasil);
		}
	}

	public function searchSupplier($id)
	{
		$response = $this->get("supplier/$id");
		return response()->json($response);
	}

	public function searchPurchaseInvoice($id)
	{
		$response = $this->getData("purchase-invoice-header/$id");
		return response()->json($response);
	}

	public function searchPurchaseInvoiceAll(Request $request, $supplier_id)
	{
		if ($request->has("q")) {
			$search = $request->q;
			$response = $this->getData("purchase-invoice-header/supplier/$supplier_id/$search");
			return response()->json($response);
		} else {
			$response = $this->getData("purchase-invoice-header/supplier/$supplier_id");
			return response()->json($response);
		}
	}


	public function getAllInventorySupplier(Request $request, $supplier_id)
	{
		if ($request->has("q")) {
			$search = $request->q;
			$response = $this->getData("po-line/supplier/$supplier_id/$search");
			return response()->json($response);
		} else {
			$response = $this->getData("po-line/supplier/$supplier_id");
			return response()->json($response);
		}
	}

	public function searchReturPrice($inven)
	{
		$response = $this->getData("po-line/$inven/inventoryproperty");
		return response()->json($response);
	}

	public function searchKategoriPengeluaran(Request $request)
	{
		if ($request->has("q")) {
			$search = $request->q;
			$response = $this->getData("kategori-pengeluaran/$search/search");
			return response()->json($response);
		} else {
			$response = $this->getData("kategori-pengeluaran");
			return response()->json($response);
		}
	}

	public function searchInventaris(Request $request)
	{
		if ($request->has("q")) {
			$search = $request->q;
			$response = $this->getData("inventaris/$search/search");
			return response()->json($response);
		} else {
			$response = $this->getData("inventaris");
			return response()->json($response);
		}
	}

	public function searchUser(Request $request)
	{
		if ($request->has("q")) {
			$search = $request->q;
			$response = $this->getData("user/$search/search");
			return response()->json($response);
		} else {
			$response = $this->getData("user");
			return response()->json($response);
		}
	}

	public function getSalesCustomerHistory($stockid, $customerid)
	{
		$response = $this->getData("sales-order-line/history/$stockid/$customerid");
		return response()->json($response);
	}
	public function getReturnCustomerHistory($stockid, $customerid)
	{
		$response = $this->getData("customer-return-line/history/$stockid/$customerid");
		return response()->json($response);
	}
}
