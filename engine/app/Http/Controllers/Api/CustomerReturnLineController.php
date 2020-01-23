<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\CustomerReturnLine as MD;
use App\CustomerReturnHeader;
use App\SalesOrderHeader;
use App\ItemStock;

class CustomerReturnLineController extends Controller
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
        foreach ($request->data as $item) {
            $data = MD::create($item);
            $item_stock = ItemStock::find($data->item_stock_id);
            $item_stock->qty += $data->qty;
            $item_stock->save();
            //
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
        $datareturheader = CustomerReturnHeader::find($data->customer_return_header_id);
        $datasalesorder = SalesOrderHeader::find($datareturheader->sales_id);
        $datasalesorder->retur -= $selisih;
        $datasalesorder->total_sales += $selisih;
        $datasalesorder->save();
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
        $selisih = ($data->qty * $data->returprice);
        $datareturheader = CustomerReturnHeader::find($data->customer_return_header_id);
        $datasalesorder = SalesOrderHeader::find($datareturheader->sales_id);
        $datasalesorder->retur -= $selisih;
        $datasalesorder->total_sales += $selisih;
        $datasalesorder->save();
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
            ->join("customer_return_header", "customer_return_header.id", "=", "customer_return_line.customer_return_header_id")
            ->where("item_stock_id", "=", $stockid)
            ->where("customer_return_header.customer_id", "=", $customerid)
            ->get();

        $response = $this->responseBase($data, 200);
        return $response;
    }
}
