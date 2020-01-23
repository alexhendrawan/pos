<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\ItemStock;
use App\SalesOrderHeader;
use App\SalesOrderLine as MD;

class SalesOrderLineController extends Controller
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

        if ($request->has("new")) {
            $data = MD::create($request->except("new"));
            $selisihtotal = ($data->qty * $data->price_per_satuan_id);
            $salesheader = SalesOrderHeader::find($data->sales_order_header_id);
            $salesheader->total_sales += $selisihtotal;
            $salesheader->payment_remain += $selisihtotal;
            $salesheader->save();
        } else {
            foreach ($request->data as $item) {
            $data = MD::create($item);
                $item_stock = ItemStock::find($data->item_stock_id);
                $item_stock->qty -= $data->qty;
                $item_stock->save();
            }
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
        $selisihtotal = ($request->qty * $request->price_per_satuan_id) - ($data->qty * $data->price_per_satuan_id);
        $selisihmodal = ($request->qty * $request->purchase_price) - ($data->qty * $data->purchase_price);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        //update stok
        $datastoklama = ItemStock::find($data->item_stock_id);
        $datastoklama->qty += $data->qty;
        $datastoklama->save();
        $datastokbaru = ItemStock::find($request->item_stock_id);
        $datastokbaru->qty -= $request->qty;
        $datastokbaru->save();

        foreach ($request->all() as $key => $value) {
            $data->$key = $value;
        }
        $data->save();
        $salesheader = SalesOrderHeader::find($data->sales_order_header_id);
        $salesheader->total_sales += $selisihtotal;
        $salesheader->payment_remain += $selisihtotal;
        $salesheader->modal += $selisihmodal ;
        $salesheader->save();

        
        $response = $this->responseBase($data, 200);
        return $response;
    }
     public function updatemodal(Request $request, $id)
    {
        $data = MD::find($id);
        // $selisihtotal = ($request->qty * $request->price_per_satuan_id) - ($data->qty * $data->price_per_satuan_id);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        foreach ($request->all() as $key => $value) {
            $data->$key = $value;
        }
        $data->save();
        // $salesheader = SalesOrderHeader::find($data->sales_order_header_id);
        // $salesheader->total_sales += $selisihtotal;
        // $salesheader->payment_remain += $selisihtotal;
        // $salesheader->save();
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
        $selisihtotal = ($data->qty * $data->price_per_satuan_id);
        $salesheader = SalesOrderHeader::find($data->sales_order_header_id);
        $salesheader->total_sales -= $selisihtotal;
        $salesheader->payment_remain -= $selisihtotal;
        $salesheader->save();
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

    public function getdatahistory($stockid, $customerid)
    {
        $data = MD::with("stock.inventoryproperty.item")
        ->join("sales_order_header","sales_order_header.id","=","sales_order_line.sales_order_header_id")
        ->where("item_stock_id","=",$stockid)
        ->where("sales_order_header.customer_id","=",$customerid)
        ->get();

        $response = $this->responseBase($data, 200);
        return $response;
    }
}
