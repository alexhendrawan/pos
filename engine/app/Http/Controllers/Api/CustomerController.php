<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Customer as MD;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MD::all();
        foreach ($data as $key) {
            $key->sales;
            $key->city;
        }
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
        $data = MD::find($id);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }

        $data->sales;
        $data->city;
        
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
    function getsorted($field, $sort, $limit) {
        $data = MD::select("*");
        $data = $data->orderBy($field, $sort);
        $data = $data->paginate($limit);
        $response = $this->responseBase($data, 200);
        return $response;
    }

    function searchByName($name){
        $data = MD::select("customer.*")
        ->join("user","user.id","=","customer.sales_id")
        ->where("customer.name","like","%".$name."%")->get();
        foreach ($data as $key) {
            $key->sales;
        }
        $response = $this->responseBase($data,200);
        return $response;
    }
}
