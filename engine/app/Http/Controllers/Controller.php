<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	// public function base_uri($api = "")
	// {
	// 	return getenv("BASEURL_API") . $api;
	// }
	public function client()
	{

		$client = new Client([
			'base_uri' => getenv("BASEURL_API"),
			'headers' => [
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer ' . session()->get('apitokenpos')
			]
		]);
		return $client;
	}

	public function get($url)
	{
		try {
			$response = $this->client()->get($url);
		} catch (\Exception $e) {
			dd($e);
		}
		$result["data"] =  json_decode($response->getBody())->data;
		return $result;
	}

	public function post($url, $data)
	{
		try {
			$response = $this->client()->post($url, ["json" => $data]);
		} catch (\Exception $e) {
			dd($e->getResponse()->getBody()->getContents());
		}

		$result["data"] =  json_decode($response->getBody())->data;
		return $result;
	}

	public function put($url, $data)
	{
		unset($data["_method"]);
		unset($data["_token"]);
		try {
			$response = $this->client()->put($url, ["json" => $data]);
		} catch (\Exception $e) {
			dd($e->getResponse()->getBody()->getContents());
		}
		$result["data"] =  json_decode($response->getBody())->data;
		return $result;
	}

	public function delete($url)
	{
		try {
			$response = $this->client()->delete($url);
		} catch (\Exception $e) {
			dd($e->getResponse()->getBody()->getContents());
		}

		$result["data"] =  json_decode($response->getBody());
		return $result;
	}

	public function backmessage($msg)
	{
		return redirect()->back()->with("message", $msg);
	}

	public function getData($url)
	{
		try {
			$response = $this->client()->get($url);
		} catch (\Exception $e) {
			dd($e->getResponse()->getBody()->getContents());
		}
		$data =  json_decode($response->getBody())->data;
		return $data;
	}
}
