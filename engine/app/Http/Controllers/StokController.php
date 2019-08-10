<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 1;
        if ($request->has("page")) {
            $page = $request->page;
        }
        $data["page"] = $page;
        $response = "";
        if ($request->has("search")) {
            $response = $this->get("item-stock/".$request->search."/search");
            $data["data"]=  $response["data"];
            $data["search"]=  $request->search;
            $data["page"] = -1;
        } else {
            if ($request->has("page")) {
                $response = $this->get("item-stock?page=$page");
            } else {
                $response = $this->get("item-stock");
            }
            $data["data"] =   $response["data"];
        }
        return view("stok.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("stok.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $stock["purchase_price"]=$request->purchase_price;
        $stock["qty"]=$request->qty;
        $stock["sell_price"]=$request->sell_price;
        $stock["item_id"]=$request->item_id;
        $stock["satuan_id"]=$request->satuan_id;
        $stock["warehouse_id"]=$request->warehouse_id;

        try {
            $response = $this->client()->post("item-stock", [
            "json"=>$stock
        ]);
        } catch (\Exception $e) {
            $response = json_decode($e->getResponse()->getBody());
        }

        return redirect()->back()->with("message", "Data Dibuat");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = $this->client()->get("item-stock/$id");
        $data["data"] =  json_decode($response->getBody())->data;
        return view("stok.edit", $data);
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
        //
        $input = $request->all();

        unset($input["_method"]);
        unset($input["_token"]);
        $response = $this->client()->put("item-stock/$id", [
            "json"=>$input
        ]);
        $data["data"] =  json_decode($response->getBody())->data;
        return redirect()->back()->with("message", "Data Diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->client()->delete("item-stock/$id");
        return $response;
    }
}
