<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class KategoriPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->client()->get("kategori-pengeluaran");
        $data["data"] =  json_decode($response->getBody())->data;
        return view("kategori-pengeluaran.index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("kategori-pengeluaran.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->client()->post("kategori-pengeluaran",[
            "json"=>$request->all()
        ]);

        return redirect("kategoripengeluaran")->with("message","Kategori Dibuat");
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
        $response = $this->client()->get("kategori-pengeluaran/$id");
        $data["data"] =  json_decode($response->getBody())->data;
        return view("kategori-pengeluaran.edit",$data);
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
        $response = $this->client()->put("kategori-pengeluaran/$id",[
            "json"=>$request->except("_token","_method")
        ]);

        return redirect("kategoripengeluaran")->with("message","Kategori Diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->client()->delete("kategori-pengeluaran/$id");
        return $response;
    }
}
