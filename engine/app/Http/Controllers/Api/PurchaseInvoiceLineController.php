<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\PurchaseInvoiceLine as MD;
use App\POLine;
use App\InventoryProperty;
use App\ItemStock;

class PurchaseInvoiceLineController extends Controller
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
        $po_line = POLine::where("id", "=", $request->po_line_id)->first();
        $itemstock = ItemStock::where("id", "=", $po_line->item_stock_id)->first();
        $data = MD::create($request->all());
        $itemstock->qty += $request->qty;
        $itemstock->deletedOn = null;
        if ($request->price_per_satuan_id != 0) {
            $itemstock->purchase_price = $request->price_per_satuan_id;
        }
        if ($request->sell_per_satuan_id != 0) {
            $itemstock->sell_price = $request->sell_per_satuan_id;
        }
        $itemstock->save();
        $po_line->penerimaan = 1;
        $po_line->save();
        $response = $this->responseBase($data, 201);
        return $response;
        // $po_line = POLine::where("id", "=", $request->po_line_id)->first();
        // $itemstock = ItemStock::where("id","=",$po_line->item_stock_id)->first();
        // $data = MD::create($request->all());
        // $itemstock->qty += $request->qty;
        // $itemstock->sell_price = $request->sell_per_satuan_id;
        // $itemstock->deletedOn = null;
        // if($request->price_per_satuan_id !=0){
        // $itemstock->purchase_price = $request->price_per_satuan_id;
        // }
        // $itemstock->save();
        // $po_line->penerimaan = 1;
        // $po_line->save();
        // $response = $this->responseBase($data, 201);
        // return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MD::find($id);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        $response = $this->responseBase($data, 200);
        return $response;
    }

     public function showByPoLine($id)
    {
        $data = MD::with("poline.inventoryproperty.item","warehouse")->where("po_line_id","=",$id)->first();
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
        $po_line = POLine::where("id", "=", $data->po_line_id)->first();

        $itemstock = ItemStock::where("id","=",$po_line->item_stock_id)->first();
        $itemstock->qty += $request->qty-$data->qty;
        $itemstock->sell_price = $request->sell_per_satuan_id;
        $itemstock->purchase_price = $request->price_per_satuan_id;
        $itemstock->save();

        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        foreach ($request->all() as $key => $value) {
            $data->$key = $value;
        }
        $data->save();

        $response = $this->responseBase($itemstock, 200);
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
}
