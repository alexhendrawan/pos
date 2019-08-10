<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->date_start == null) {
            $request->date_start = $myDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-1 month"));
        }
        if ($request->date_end == null) {
            $request->date_end = date("Y-m-d");
        }
        $response = $this->get("pengeluaran/"."?date_start=".$request->date_start."&date_end=".$request->date_end);
        $data["data"] =  $response["data"];

        return view("pengeluaran.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("pengeluaran.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(json_encode($request->all()));
        $this->post("pengeluaran", $request->all());
        return redirect()->back()->with("message","pengeluaran Dibuat");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return view("pengeluaran.show",$this->get("pengeluaran/$id"));
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
       $this->put("pengeluaran/$id",$request->all());
       return redirect()->back()->with("message","pengeluaran Diubah");
   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->delete("pengeluaran/$id");
        return redirect()->back()->with("message","pengeluaran Dihapus");
    }
}
