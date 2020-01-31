<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // public function base_uri($api = "")
    // {
    //     return getenv("BASEURL_API") . $api;
    // }
    public function client()
    {

        $client = new Client([
            // 'base_uri' =>'http://localhost/api/v1/',
            'base_uri' => 'http://localhost/kemilau/api/v1/',
            'headers' => [
                'Content-Type' => 'application/json',
                // ,
                // 'Authorization' => 'Bearer ' . session()->get('apitokenpos')
            ],
        ]);
        return $client;
    }

    public function get($url)
    {
        // dd($this->client());

        $response = $this->client()->get($url);
        $result["data"] = json_decode($response->getBody())->data;
        return $result;
    }

    public function post($url, $data)
    {
        $response = $this->client()->post($url, ["json" => $data]);
        // dd($e->getResponse()->getBody()->getContents());

        $result["data"] = json_decode($response->getBody())->data;
        return $result;
    }

    public function put($url, $data)
    {
        unset($data["_method"]);
        unset($data["_token"]);
        $response = $this->client()->put($url, ["json" => $data]);
        $result["data"] = json_decode($response->getBody())->data;
        return $result;
    }

    public function delete($url)
    {
        try {
            $response = $this->client()->delete($url);
        } catch (\Exception $e) {
        }

        $result["data"] = json_decode($response->getBody());
        return $result;
    }

    public function backmessage($msg)
    {
        return redirect()->back()->with("message", $msg);
    }

    public function getData($url)
    {
        $response = $this->client()->get($url);
        $data = json_decode($response->getBody())->data;
        return $data;
    }
}
