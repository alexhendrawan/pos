<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SalesOrderHeader;
use App\SalesOrderLine;
use PDF;

class UpdateController extends Controller
{ 
    function updatemodal() {

        $response = $this->getData("customer-shipment-header/");

        foreach ($response->content as $key) {
            $salesheader_id = $key->sales->id;
            $salesheadercreated = $key->sales->createdOn;
            if($salesheadercreated >= "2019-09-05"){
            $response2 = $this->getData("sales-order-header/" . $salesheader_id);
            $total = 0;
                foreach ($response2->detail as $lines) {
                    
                    if ($lines->price_per_satuan_id != 0) {
                        $total += $lines->stock->purchase_price * $lines->qty;
                        $arr = array();
                        $arr["sales_per_satuan_id"] = $lines->stock->purchase_price;
                        $response4 = $this->put("sales-order-line/update" . "/" . $lines->id, $arr);
                        echo "Sales Order lIne ID:" . $lines->id . "<br>";
                    } else {
                        $total += 0 * $lines->qty;
                        $arr = array();
                        $arr["sales_per_satuan_id"] = $lines->stock->purchase_price;
                    $response4 = $this->put("sales-order-line/update" . "/" . $lines->id, $arr);

                        echo "Sales Order lIne ID:" . $lines->id . "<br>";
                    }
                    

                    $ray = array();
                    $ray["modal"] = $total;
                    $response3 = $this->put("sales-order-header" . "/$salesheader_id",$ray);
                    echo "done for header id " . $salesheader_id . "<br>";
                }
            }
        }
        echo "all done..";
    }


    function updatehargabeli() {
        $response = $this->getData("po-line");
        foreach ($response as $key) {
          if($key->createdOn >= "2019-08-01"){

            $poline_id = $key->id;
            $response2 = $this->getData("purchase-invoice-line/".$poline_id."/poline");
            if(isset($response2->poline)){
            $item_id = $response2->poline->inventoryproperty->id;
            $purchase_price = $response2->price_per_satuan_id;


            if($purchase_price !=0){

            // if($item_id == 5004){
                $arr["item_id"] = $item_id;
                $arr["purchase_price"] = $purchase_price;
                 $response = $this->put("item-stock/purchasepriceupdate/",$arr);
                echo "Item Inventory ".$item_id."<br>";
            // }
                // $response3 = $this->put("item-stock/purchasepriceupdate/".$item_id."/".$purchase_price);
                // echo "Item Inventory ".$item_id."<br>";
            }
        }
        }
        }
        echo "all done..";
    }

    function hapussaleskosong(){
        $dari = "2019-08-01 00:00:00";
        $sampai = "2019-08-31 23:59:59";

        $data = SalesOrderHeader::wherebetween("createdOn",[$dari, $sampai])->get();
        // $data = SalesOrderHeader::where("id","=",17501)->get();
        foreach($data as $sales){
            $line = SalesOrderLine::where("sales_order_header_id", "=", $sales->id)->get();
            if(count($line)==0){
                // dd("nah");
                echo "deleted id ".$sales->id."<br>";
                $sales->delete();
            }            
        }
    }

    function updatesisapembayaran() {

        $response = $this->client->get($this->base_uri("sales_order_header"));
        $hasil = json_decode($response->getBody()->getContents());

        foreach ($hasil->data as $key) {
            $query = DB::table('sales_invoice_payment')
            ->select(DB::raw('SUM(`payment_value`) as "totalsales"'))
            ->where('sales_order_header_id', '=', $key->id)
            ->first();
            $totalsales = 0;
            if ($query->totalsales != null) {
                $totalsales = $query->totalsales;
            }
            $arr["payment_remain"] = $totalsales;
            $response = $this->client->put($this->base_uri("sales_order_header/update/sisa/" . $key->id), ['json' => $arr]);
            echo "Done for sales header id " . $key->id . "<br>";
        }
        echo "all done..";
    }
}
