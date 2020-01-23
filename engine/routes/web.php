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

// Route::prefix('update')->group(function (){
//     Route::get("modal","UpdateController@updatemodal");
//     Route::get("hargabeli","UpdateController@updatehargabeli");
//     Route::get("saleskosong","UpdateController@hapussaleskosong");
// });

Route::prefix('print/faktur')->group(function () {
    Route::get('po/{id}', "LaporanController@printpo");
    Route::get('penjualan/{id}', "LaporanController@printfakturpenjualan");
    Route::get('pembelian/{id}', "LaporanController@printfakturpembelian");
    Route::get('pembayaran-faktur/{id}', "LaporanController@printfakturpenjualanbayar");
    Route::get('retur-pembelian/{id}', "LaporanController@printfakturreturpembelian");
    Route::get('retur-penjualan/{id}', "LaporanController@printfakturreturpenjualan");
});

Route::prefix('api/v1')->group(function () {
    Route::get("update/modal", "Api\CustomerShipmentHeaderController@updatemodal");
    Route::get("update/hargabeli", "Api\ItemStockController@updatehargabeli");

    Route::get("item-stock/allindex", "Api\ItemStockController@indexAll");
    Route::get("po-header/{status}/riwayat", "Api\POHeaderController@getByStatus");
    Route::get("po-header/{id}/detail", "Api\POHeaderController@detail");
    Route::get("purchase-invoice-header/{status}/riwayat", "Api\PurchaseInvoiceHeaderController@getByStatus");

    Route::get("item-stock/datatable", "Api\ItemStockController@indexDataTable");
    Route::get("item-stock/{id}/detail", "Api\ItemStockController@detailStock");
    Route::get("customer-shipment-header/search", "Api\CustomerShipmentHeaderController@search");
    Route::get("customer-shipment-header/{key}/{search}/searchCustomer", "Api\CustomerShipmentHeaderController@searchCustomer");
    Route::get("sales-invoice-payment/search", "Api\SalesInvoicePaymentController@search");
    Route::get("user/{role}/role", "Api\UserController@searchByRole");
    Route::get("item-stock/{name}/search", "Api\ItemStockController@searchByName");
    Route::get("customer/{name}/search", "Api\CustomerController@searchByName");
    Route::get("sales-order-header/{customer_id}/hutang", "Api\SalesOrderHeaderController@calculateHutang");
    Route::get("sales-order-header/{customer_id}/riwayat", "Api\SalesOrderHeaderController@detailHutang");
    Route::get("sales-order-header/{customer_id}/hutang/id", "Api\SalesOrderHeaderController@detailHutangID");
    Route::get("sales-order-header/{customer_id}/customer", "Api\SalesOrderHeaderController@getDataByCustomer");
    Route::get("sales-order-header/{customer_id}/customer/{nomor}", "Api\SalesOrderHeaderController@getDataByCustomerNomor");
    Route::get("sales-order-header/piutang", "Api\SalesOrderHeaderController@getHutang");
    Route::get("brand/{name}/search", "Api\BrandController@searchByName");
    Route::get("category/{name}/search", "Api\CategoryController@searchByName");
    Route::get("inventory-property/{item_id}/item", "Api\InventoryPropertyController@getbyIdItem");
    Route::get("inventory-property/{name}/search", "Api\InventoryPropertyController@searchByName");
    Route::get("satuan/{name}/search", "Api\SatuanController@searchByName");
    Route::get("city/{name}/search", "Api\CityController@searchByName");
    Route::get("user/sales/{name}/search", "Api\UserController@searchByNameSales");
    Route::get("user/sales", "Api\UserController@indexSales");
    Route::get("supplier/{name}/search", "Api\SupplierController@searchByName");
    Route::get("item-stock/inven/{id}", "Api\ItemStockController@searchSatuan");
    Route::get("po-header/penerimaan/{id}/detail", "Api\POHeaderController@detailPenerimaan");
    Route::get("po-header/status/{id}", "Api\POHeaderController@status");
    Route::get("customer-shipment-header/detail/{sales_id}", "Api\CustomerShipmentHeaderController@getDetail");
    Route::get("purchase-invoice-header/supplier/{supplier_id}/{search?}", "Api\PurchaseInvoiceHeaderController@getSupplier");
    Route::get("po-line/supplier/{supplier_id}/{search?}", "Api\POLineController@getInventoryPropertySupplier");
    Route::get("po-line/{inven}/inventoryproperty", "Api\POLineController@getReturPrice");
    Route::put("purchase-invoice-header/{po_id}/po", "Api\PurchaseInvoiceHeader@editByPO");
    Route::get("kategori-pengeluaran/{name}/search", "Api\KategoriPengeluaranController@searchByName");
    Route::get("inventaris/{name}/search", "Api\InventorisController@searchByName");
    Route::get("user/{search}/search", "Api\UserController@searchByName");
    Route::get("sales-order-line/history/{stockid}/{customerid}", "Api\SalesOrderLineController@getdatahistory");
    Route::get("customer-return-line/history/{stockid}/{customerid}", "Api\CustomerReturnLineController@getdatahistory");
    Route::get("po-line/{inven_id}/{supplier_id}/history", "Api\POLineController@lastthree");
    Route::get("purchase-invoice-line/{id}/poline", "Api\PurchaseInvoiceLineController@showByPoLine");
    Route::put("item-stock/purchasepriceupdate", "Api\ItemStockController@updatehargabeli");
    Route::put("sales-order-line/update/{id}", "Api\SalesOrderLineController@updatemodal");

    Route::resource("bank-cash-adjustment", "Api\BankCashAdjustmentController");
    Route::resource("bank-cash", "Api\BankCashController");
    Route::resource("bank-cash-payment", "Api\BankCashPaymentController");
    Route::resource("bank-cash-transaction", "Api\BankCashTransactionController");
    Route::resource("bank-cash-transfer", "Api\BankCashTransferController");
    Route::resource("branch", "Api\BranchController");
    Route::resource("brand", "Api\BrandController");
    Route::resource("category", "Api\CategoryController");
    Route::resource("city", "Api\CityController");
    Route::resource("counter", "Api\CounterController");
    Route::resource("credit-memo", "Api\CreditMemoController");
    Route::resource("credit-memo-settlement", "Api\CreditMemoSettlementController");
    Route::resource("customer", "Api\CustomerController");
    Route::resource("customer-return-header", "Api\CustomerReturnHeaderController");
    Route::resource("customer-return-line", "Api\CustomerReturnLineController");
    Route::resource("customer-shipment-header", "Api\CustomerShipmentHeaderController");
    Route::resource("customer-shipment-line", "Api\CustomerShipmentLineController");
    Route::resource("customer-shipment-return", "Api\CustomerShipmentReturnController");
    Route::resource("debit-memo", "Api\DebitMemoController");
    Route::resource("debit-memo-settlement", "Api\DebitMemoSettlementController");
    Route::resource("internal-transfer-header", "Api\InternalTransferHeaderController");
    Route::resource("internal-transfer-line", "Api\InternalTransferLineController");
    Route::resource("inventaris", "Api\InventorisController");
    Route::resource("inventory-property", "Api\InventoryPropertyController");
    Route::resource("item", "Api\ItemController");
    Route::resource("item-stock", "Api\ItemStockController");
    Route::resource("kategori-pengeluaran", "Api\KategoriPengeluaranController");
    Route::resource("komisi", "Api\KomisiController");
    Route::resource("pengeluaran", "Api\PengeluaranController");
    Route::resource("po-dp", "Api\PODPController");
    Route::resource("po-header", "Api\POHeaderController");
    Route::resource("po-line", "Api\POLineController");
    Route::resource("province", "Api\ProvinceController");
    Route::resource("purchase-invoice-header", "Api\PurchaseInvoiceHeaderController");
    Route::resource("purchase-invoice-line", "Api\PurchaseInvoiceLineController");
    Route::resource("purchase-invoice-payment", "Api\PurchaseInvoicePaymentController");
    Route::resource("role", "Api\RoleController");
    Route::resource("sales-dp", "Api\SalesDPController");
    Route::resource("sales-invoice-header", "Api\SalesInvoiceHeaderController");
    Route::resource("sales-invoice-line", "Api\SalesInvoiceLineController");
    Route::resource("sales-invoice-payment", "Api\SalesInvoicePaymentController");
    Route::resource("sales-order-header", "Api\SalesOrderHeaderController");
    Route::resource("sales-order-line", "Api\SalesOrderLineController");
    Route::resource("satuan", "Api\SatuanController");
    Route::resource("settings", "Api\SettingController");
    Route::resource("stock-mutation", "Api\StockMutationController");
    Route::resource("stock-opname", "Api\StockOpnameController");
    Route::resource("supplier", "Api\SupplierController");
    Route::resource("supplier-return-header", "Api\SupplierReturnHeaderController");
    Route::resource("supplier-return-line", "Api\SupplierReturnLineController");
    Route::resource("user", "Api\UserController");
    Route::resource("warehouse", "Api\WarehouseController");
});

Route::group(['middleware' => ['auth']], function () {
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
        Route::post('rpenjualan', "LaporanController@getlaporanreturpenjualan");
        Route::post('rpembelian', "LaporanController@getlaporanreturpembelian");
        Route::post('opname', "LaporanController@getlaporanstockopname");
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
    Route::get("cekpiutang", "PiutangController@markfordelete");
    Route::resource("retur-penjualan", "ReturPenjualanController");
    Route::resource("retur-penjualan-line", "ReturPenjualanLineController");

    Route::resource("po", "POController");
    Route::resource("po-line", "POLineController");
    Route::resource("penerimaan", "PenerimaanController");
    Route::resource("hutang", "HutangController");
    Route::get("cekhutang", "HutangController@markfordelete");

    Route::resource("retur-pembelian", "ReturPembelianController");
    Route::resource("retur-pembelian-line", "ReturPembelianLineController");

    Route::resource("pengeluaran", "PengeluaranController");
    Route::resource("kategoripengeluaran", "KategoriPengeluaranController");

    Route::resource("stock_opname", "StockOpnameController");
});

Auth::routes();
