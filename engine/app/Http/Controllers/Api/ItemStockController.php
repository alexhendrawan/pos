<?php

namespace App\Http\Controllers\Api;

use App\CustomerReturnLine;
use App\ItemStock as MD;
use App\POLine;
use App\PurchaseInvoiceLine;
use App\SalesOrderLine;
use App\Satuan;
use App\StockMutation;
use App\SupplierReturnLine;
use Illuminate\Http\Request;

class ItemStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAll()
    {
        $data = MD::with("Warehouse", "Satuan", "Inventoryproperty", "Inventoryproperty.Brand", "Inventoryproperty.Category", "Inventoryproperty.Item")
            ->paginate(50);
        $response = $this->responseBase($data, 200);
        return $response;
    }
    public function index()
    {
        $data = MD::with("Warehouse", "Satuan", "Inventoryproperty", "Inventoryproperty.Brand", "Inventoryproperty.Category", "Inventoryproperty.Item")
            ->paginate(50);
        $response = $this->responseBase($data, 200);
        return $response;
    }

    // public function indexDataTable(Request $request)
    // {
    //     // dd($request->all());
    //   // $draw = $request->limit;
    //   $draw = $request->length;
    //   $recordsTotal = MD::all()->count();
    //   $recordsFiltered = $recordsTotal;

    //   $content = MD::limit($draw)->get();
    //   // dd($content);
    //   foreach ($content as $key) {
    //     $key->satuan;
    //     $key->warehouse;
    //     $key->inventoryproperty->brand;
    //     $key->inventory_property->category;
    //     $key->inventory_property->item;
    //   }

    //   $data["draw"] = $draw;
    //   $data["recordsTotal"] = $recordsTotal;
    //   $data["recordsFiltered"] = $recordsFiltered;
    //   $data["data"] = $content;

    //   $response = $this->responseBase($data, 200);
    //   return $response;
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  $validate = Validator::make($request->all(), [
        //     'item_id' => 'unique:item_stock'
        // ]);
        //  if ($validate->fails()) {
        //     return $this->responseBase("Stok Sudah Ada", 400);
        // }
        $arr["code"] = $this->incrementalHash();
        $request->merge($arr);
        $data = MD::create($request->all());
        $response = $this->responseBase($data, 201);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MD::with("Warehouse", "Satuan", "Inventoryproperty", "Inventoryproperty.Brand", "Inventoryproperty.Category", "Inventoryproperty.Item")->find($id);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        $response = $this->responseBase($data, 200);
        return $response;
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
        $data = MD::find($id);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        foreach ($request->all() as $key => $value) {
            $data->$key = $value;
        }
        $data->save();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = MD::find($id);
        if ($data == null) {
            $response = $this->responseBase("Tidak Ada Data", 404);
            return $response;
        } else {
            $data->delete();
            $response = $this->responseBase($data, 200);
            return $response;
        }
    }

    //additional
    public function getsorted($field, $sort, $limit)
    {
        $data = MD::select("*");
        $data = $data->orderBy($field, $sort);
        $data = $data->paginate($limit);
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function searchByName($name)
    {
        $data["data"] = MD::with("Warehouse", "Satuan", "Inventoryproperty", "Inventoryproperty.Brand", "Inventoryproperty.Category", "Inventoryproperty.Item")
            ->select("item_stock.*")
            ->join("inventory_property", "inventory_property.id", "=", "item_stock.item_id")
            ->join("item", "item.id", "=", "inventory_property.item_id")
            ->where("item.item_name", "like", "%" . $name . "%")->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function searchSatuan($id)
    {
        $item_stock = MD::where("item_id", "=", $id)->first();
        $satuan = Satuan::find($item_stock->satuan_id);
        $response = $this->responseBase($satuan, 200);
        return $response;
    }

    public function updatehargabeli()
    {
        $response = POLine::wherebetween("createdOn", ["2019-09-01 00:00:00", "2019-11-30 23:59:59"])->get();
        foreach ($response as $key) {

            $poline_id = $key->id;
            $response2 = PurchaseInvoiceLine::with("poline")->where("po_line_id", "=", $key->id)->get();

            if (isset($response2->poline)) {
                $item_id = $response2->poline->inventoryproperty->id;
                $purchase_price = $response2->price_per_satuan_id;

                if ($purchase_price != 0) {
                    $stock = MD::where("item_id", "=", $item_id)->first();
                    $stock->purchase_price = $purchase_price;
                    $stock->save();
                }
            }
        }
        echo "all done..";
    }

    public function detailStock($id)
    {
        $opname = StockMutation::where("item_stock_id", $id)->orderby("createdOn", "desc")->first();
        $data["opname"] = StockMutation::where("item_stock_id", $id)->where("createdOn", ">", "2020-01-08 00:00:00")->orderby("createdOn", "desc")->first();
        $data["penjualan"] = SalesOrderLine::where("item_stock_id", $id)->where("createdOn", ">", "2020-01-08 00:00:00")->orderby("createdOn", "desc")->get();
        $data["pembelian"] = POLine::with("purchaseline")->where("item_stock_id", $id)->where("createdOn", ">", "2020-01-08 00:00:00")->orderby("createdOn", "desc")->get();
        $data["returpenjualan"] = CustomerReturnLine::where("item_stock_id", $id)->where("createdOn", ">", "2020-01-08 00:00:00")->orderby("createdOn", "desc")->get();
        $data["returpembelian"] = SupplierReturnLine::where("item_stock_id", $id)->where("createdOn", ">", "2020-01-08 00:00:00")->orderby("createdOn", "desc")->get();

        $response = $this->responseBase($data, 200);
        return $response;

    }
}
