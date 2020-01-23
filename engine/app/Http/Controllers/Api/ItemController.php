<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Item as MD;
use Illuminate\Support\Facades\Validator;
use App\InventoryProperty;

class ItemController extends Controller
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


        $validate = Validator::make($request->all(), [
            'item_name' => 'unique:item'
        ]);

        $arr["item_code"] = $this->incrementalHash();
        $request->merge($arr);
        if ($validate->fails()) { 
            return $this->responseBase("Item Sudah Ada", 400);
        }
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
        $inven = InventoryProperty::where("item_id","=",$id)->first();
        if ($data == null) {
            $response = $this->responseBase("Tidak Ada Data", 404);
            return $response;
        } else {
            $data->delete();
            $inven->delete();
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
}
