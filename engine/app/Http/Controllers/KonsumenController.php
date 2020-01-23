<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KonsumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->client()->get("customer");
        $data["data"] =  json_decode($response->getBody())->data;
        return view("konsumen.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("konsumen.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $input = $request->all();
      unset($input["_token"]);
      $response = $this->client()->post("customer",[
        "json"=>$input
    ]);
      return redirect()->back()->with("message","Data Dibuat");
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->client()->get("customer/$id");
        $data["data"] =  json_decode($response->getBody())->data;
        return view("konsumen.show",$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $input = $request->all();
        unset($input["_method"]);
        unset($input["_token"]);
        $response = $this->client()->put("customer/$id",[
            "json"=>$input
        ]);
        return redirect()->back()->with("message","Data Diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
               $response = $this->client()->delete("customer/$id");
        return $response;
    }
}
