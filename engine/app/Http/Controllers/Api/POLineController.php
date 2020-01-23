<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\POLine as MD;
use App\ItemStock;
use App\Inventoryproperty;
use DB;

class POLineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MD::all();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inventory = Inventoryproperty::find($request->inventory_property_id);
        $itemstock = ItemStock::where("item_id", "=", $request->inventory_property_id)->first();
        if($itemstock == null){
            $new["code"]=$this->incrementalHash();
            $new["purchase_price"] = 0;
            $new["sell_price"] =0 ;
            $new["qty"] = 0;
            $new["size"] = 0.0;
            $new["item_id"] = $request->inventory_property_id;
            if($request->satuan_id == null){
            $new["satuan_id"] = 37;

            }else{
            $new["satuan_id"] = $request->satuan_id;

            }
            $new["warehouse_id"] = 1;

            $itemstock = ItemStock::create($new);
        }
        $arr["item_stock_id"] = $itemstock->id;
        $arr["penerimaan"] = 0;
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
        $data = MD::with("Satuan", "Stock.Inventoryproperty.Item", "Inventoryproperty.Item", "Inventoryproperty.Category", "Inventoryproperty.Brand")->find($id);
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

    public function getInventoryPropertySupplier($supplier_id, $search = null)
    {
        $data = [];
        if ($search == null) {
            $data =  MD::select("inventory_property.id", "item.item_name")
                ->join("po_header", "po_header.id", "=", "po_line.po_header_id")
                ->join("inventory_property", "inventory_property.id", "=", "po_line.inventory_property_id")
                ->join("item", "item.id", "=", "inventory_property.item_id")
                ->where("po_header.supplier_id", "=", $supplier_id)
                ->get();
        } else {
            $data =  MD::select(DB::raw("distinct(item.item_name), inventory_property.id"))
                ->join("po_header", "po_header.id", "=", "po_line.po_header_id")
                ->join("inventory_property", "inventory_property.id", "=", "po_line.inventory_property_id")
                ->join("item", "item.id", "=", "inventory_property.item_id")
                ->where("po_header.supplier_id", "=", $supplier_id)
                ->where("item.item_name", "like", "%" . $search . "%")
                ->get();
        }
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function getReturPrice($inven)
    {
        $itemstock = ItemStock::find($inven);

        $data =  MD::select("purchase_invoice_line.price_per_satuan_id")
            ->join("purchase_invoice_line", "purchase_invoice_line.po_line_id", "=", "po_line.id")
            ->where("po_line.inventory_property_id", "=", $itemstock->item_id)
            ->orderby("purchase_invoice_line.createdOn", "desc")
            ->first();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function lastthree($inven_id, $supplier_id)
    {
        $itemstock = ItemStock::find($inven_id);
        $data =  MD::select("*")
            ->join("po_header", "po_header.id", "=", "po_line.po_header_id")
            ->join("inventory_property", "inventory_property.id", "=", "po_line.inventory_property_id")
            ->join("item", "item.id", "=", "inventory_property.item_id")
            ->where("po_header.supplier_id", "=", $supplier_id)
            ->where("po_line.inventory_property_id", "=", $itemstock->item_id)
            ->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }
}
