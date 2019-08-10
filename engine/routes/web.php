<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::prefix('print/faktur')->group(function () {
	Route::get('po/{id}', "LaporanController@printpo");
	Route::get('penjualan/{id}', "LaporanController@printfakturpenjualan");
	Route::get('pembelian/{id}', "LaporanController@printfakturpembelian");
	Route::get('pembayaran-faktur/{id}', "LaporanController@printfakturpenjualanbayar");
	Route::get('returpembelian/{id}', "LaporanController@printfakturreturpembelian");
	Route::get('retur-penjualan/{id}', "LaporanController@printfakturreturpenjualan");
});

Route::group(['middleware' => ['checktoken']], function () {
	Route::get('/', function () {
		return view('index');
	});



	//Ajax
	Route::get("ajax/customer", "AjaxController@getAllConsumer");
	Route::get("ajax/customer/{id}", "AjaxController@searchConsumer");
	Route::get("ajax/customer/{id}/hutang", "AjaxController@sumConsumerHutang");
	Route::get("ajax/customer/{id}/riwayat", "AjaxController@detailConsumerHutang");
	Route::get("ajax/customer/{id}/riwayat/id", "AjaxController@detailConsumerHutangById");
	Route::get("ajax/itemstock", "AjaxController@getAllStock");
	Route::get("ajax/itemstock/{id}", "AjaxController@searchStock");
	Route::get("ajax/inventoryproperty", "AjaxController@getAllInven");
	Route::get("ajax/inventoryproperty/{id}", "AjaxController@searchInven");
	Route::get("ajax/sales/hutang", "AjaxController@getSearchSalesByCustomer");
	Route::get("ajax/sales/{customer_id}/customer", "AjaxController@getSearchSalesByCustomerID");
	Route::get("ajax/sales/{id}", "AjaxController@searchSalesById");
	Route::get("ajax/brand", "AjaxController@getAllBrand");
	Route::get("ajax/category", "AjaxController@getAllCategory");
	Route::get("ajax/itemstok/datatable", "AjaxController@getAllStockDataTable");
	Route::get("ajax/gudang", "AjaxController@getAllGudang");
	Route::get("ajax/satuan", "AjaxController@getAllSatuan");
	Route::get("ajax/city", "AjaxController@getAllCity");
	Route::get("ajax/sales", "AjaxController@getAllSalesman");
	Route::get("ajax/role", "AjaxController@getAllRole");
	Route::get("ajax/supplier", "AjaxController@getAllSupplier");
	Route::get("ajax/supplier/inventoryproperty/{supplier_id}", "AjaxController@getAllInventorySupplier");
	Route::get("ajax/supplier/{id}", "AjaxController@searchSupplier");
	Route::get("ajax/item_stock/inven/{id}", "AjaxController@searchSatuanStock");
	Route::get("ajax/purchase_invoice/{id}", "AjaxController@searchPurchaseInvoice");
	Route::get("ajax/purchase_invoice/{supplier_id}/supplier", "AjaxController@searchPurchaseInvoiceAll");
	Route::get("ajax/po_line/{id}/inventoryproperty", "AjaxController@searchReturPrice");
	Route::get("ajax/kategori-pengeluaran", "AjaxController@searchKategoriPengeluaran");
	Route::get("ajax/user", "AjaxController@searchUser");
	Route::get("ajax/inventaris", "AjaxController@searchInventaris");
	Route::get("ajax/salescustomerhistory/{stokid}/{cabangid}", "AjaxController@getSalesCustomerHistory");
	Route::get("ajax/returncustomerhistory/{stokid}/{cabangid}", "AjaxController@getReturnCustomerHistory");
	Route::get("ajax/returnsupplierhistory/{invenid}/{supplierid}", "AjaxController@getReturnSupplierHistory");


	//Additional
	Route::get("penjualan/search", "PenjualanController@search");
	Route::get("piutang/search", "PiutangController@search");
	Route::get("po/detail/{id}", "POController@detail");
	Route::get("penerimaan/{id}/create", "PenerimaanController@create");
	Route::get("penjualan-detail/{id}/create", "PenjualanDetailController@create");
	Route::post("penjualan-detail/{id}", "PenjualanDetailController@store");
	Route::prefix('report')->group(function () {
		Route::get('/', function () {
			return view('laporan');
		});

		Route::post('/barang', "LaporanController@getlaporanbarang");
		Route::post('/stock', "LaporanController@getlaporanstock");
		Route::post('/penjualan', "LaporanController@getlaporanpenjualan");
		Route::post('/komisi', "LaporanController@getlaporankomisi");
		Route::post('/pembelian', "LaporanController@getlaporanpembelian");
		Route::post('/piutang', "LaporanController@getlaporanpiutang");
		Route::post('/hutang', "LaporanController@getlaporanhutang");
		Route::post('/pengeluaran', "LaporanController@getlaporanpengeluaran");
		Route::post('/labarugi', "LaporanController@getlaporanlabarugi");
		Route::post('/penjualankonsumen', "LaporanController@getlaporanpenjualankonsumen");
		Route::post('/pembeliansupplier', "LaporanController@getlaporanpembeliansupplier");
	});

	//Master
	Route::resource("gudang", "GudangController");
	Route::resource("barang", "BarangController");
	Route::resource("stok", "StokController");
	Route::resource("merk", "MerkController");
	Route::resource("kategori", "KategoriController");
	Route::resource("konsumen", "KonsumenController");
	Route::resource("supplier", "SupplierController");
	Route::resource("inventaris", "InventarisController");
	Route::resource("karyawan", "UserController");
	Route::resource("role", "RoleController");

	//Transaksi
	Route::resource("penjualan", "PenjualanController");
	Route::resource("penjualan-detail", "PenjualanDetailController");
	Route::resource("piutang", "PiutangController");
	Route::resource("retur-penjualan", "ReturPenjualanController");
	Route::resource("retur-penjualan-line", "ReturPenjualanLineController");

	Route::resource("po", "POController");
	Route::resource("po-line", "POLineController");
	Route::resource("penerimaan", "PenerimaanController");
	Route::resource("hutang", "HutangController");
	Route::resource("retur-pembelian", "ReturPembelianController");
	Route::resource("retur-pembelian-line", "ReturPembelianLineController");

	Route::resource("pengeluaran", "PengeluaranController");
	Route::resource("kategoripengeluaran", "KategoriPengeluaranController");
});
