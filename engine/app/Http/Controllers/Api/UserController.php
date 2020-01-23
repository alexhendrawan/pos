<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\User as MD;
use App\Role;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MD::with("Role")->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function indexSales()
    {
        $data = MD::where("role_id", "=", 3)->get();
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
        $request->password = Hash::make($request->password);
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

    public function searchByRole($role)
    {
        $role = Role::where("name", $role)->first();
        $data = MD::where("role_id", $role->id)->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function searchByNameSales($name)
    {
        $data = MD::select("user.*")
     ->where("role_id", "=", 3)
     ->where("displayName", "like", "%".$name."%")->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }
 
    public function searchByName($name)
    {
        $data = MD::select("*")
    ->where("displayName", "like", "%".$name."%")->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }
}
