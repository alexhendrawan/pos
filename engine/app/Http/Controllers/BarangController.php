<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;

class BarangController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$response = $this->client()->get("item");
		$data["data"] = json_decode($response->getBody())->data;
		return view("barang.index", $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view("barang.form");

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		//insert Item
		$item["item_name"] = $request->item_name;
		try{
			$response = $this->client()->post("item", [
				"json" => $item
			]);
		}catch (ClientException $e){
			$response = json_decode($e->getResponse()->getBody());
			return redirect()->back()->with("message",$response->data);
		}
		$response = json_decode($response->getBody())->data;

		//Insert Inventory Property
		$inven["item_id"] = $response->id;
		$inven["threshold_bottom"] = $request->threshold_bottom;
		$inven["threshold_top"] = $request->threshold_top;
		$inven["brand_id"] = $request->brand_id;
		$inven["category_id"] = $request->category_id;
		$response = $this->client()->post("inventory-property", [
			"json" => $inven
		]);

		$data["data"] = json_decode($response->getBody())->data;
		return redirect()->back()->with("message","Data Dibuat");
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$response = $this->client()->get("inventory-property/" . $id."/item");
		$data["data"] = json_decode($response->getBody())->data;
		return view("barang.edit", $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//insert Item
		$item["item_name"] = $request->item_name;
		$item["item_code"] = $request->item_code;
		try{
			$response = $this->client()->put("item/$id", [
				"json" => $item
			]);
		}catch (ClientException $e){
			$response = json_decode($e->getResponse()->getBody());
			return redirect()->back()->with("message",$response->data);
		}
		$response = json_decode($response->getBody())->data;

		//Insert Inventory Property
		$inven["item_id"] = $response->id;
		$inven["threshold_bottom"] = $request->threshold_bottom;
		$inven["threshold_top"] = $request->threshold_top;
		$inven["brand_id"] = $request->brand_id;
		$inven["category_id"] = $request->category_id;
		$response = $this->client()->put("inventory-property/$id", [
			"json" => $inven
		]);

		$data["data"] = json_decode($response->getBody())->data;
		return redirect()->back()->with("message","Data Diedit");
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
}
