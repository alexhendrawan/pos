<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\SupplierReturnLine as MD;
use App\ItemStock;
use App\SupplierReturnHeader;
use App\PurchaseInvoiceHeader;

class SupplierReturnLineController extends Controller
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

        $data = [];
        foreach ($request->data as $item) {
            // dd($item);


            $item_stock = ItemStock::find($item['item_id']);
            $item_stock->qty -= $item['qty'];
            $item_stock->save();
            $item['item_id'] = $item_stock->item_id;
            $item['item_stock_id'] = $item_stock->id;
            $data = MD::create($item);
            //19901700 0029 pajagalan
        }
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
        $data = MD::with("Stock.Inventoryproperty.Item")->find($id);
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
        $selisih = ($data->qty * $data->returprice) - ($request->qty * $request->returprice);
        $datareturheader = SupplierReturnHeader::find($data->supplier_return_header_id);
        $datapurchaseorder = PurchaseInvoiceHeader::where("poheader_id", "=", $datareturheader->po_id);
        $datapurchaseorder->retur -= $selisih;
        $datapurchaseorder->total_sales += $selisih;
        $datapurchaseorder->save();
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

        // $data = MD::find($id);
        // if ($data == null) {
        //     $response = $this->responseBase([], 404);
        //     return $response;
        // }
        // foreach ($request->all() as $key => $value) {
        //     $data->$key = $value;
        // }
        // $data->save();
        // $response = $this->responseBase($data, 200);
        // return $response;
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
        $selisih = ($data->qty * $data->returprice);
        $datareturheader = SupplierReturnHeader::find($data->supplier_return_header_id);
        $datapurchaseorder = PurchaseInvoiceHeader::where("poheader_id", "=", $datareturheader->po_id);
        $datapurchaseorder->retur -= $selisih;
        $datapurchaseorder->total_sales += $selisih;
        $datapurchaseorder->save();
        if ($data == null) {
            $response = $this->responseBase("Tidak Ada Data", 404);
            return $response;
        } else {
            $data->delete();
            $response = $this->responseBase($data, 200);
            return $response;
        }
        // $data = MD::find($id);
        // if ($data == null) {
        //     $response = $this->responseBase("Tidak Ada Data", 404);
        //     return $response;
        // } else {
        //     $data->delete();
        //     $response = $this->responseBase($data, 200);
        //     return $response;
        // }
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
