<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\SupplierReturnHeader as MD;
use App\PurchaseInvoiceHeader;
use App\POHeader;
use App\SupplierReturnLine;
use App\Counter;

class SupplierReturnHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lastday = "";
        if ($request->date_start == null) {
            $request->date_start = date("Y") . "-" . date("m") . "-" . "01";
            $lastday = date('t', strtotime($request->date_start));
        }
        if ($request->date_end == null) {
            $request->date_end = date("Y") . "-" . date("m") . "-" . $lastday;
        }
        $data["content"] = MD::with("Supplier")
            ->where("createdOn", ">=",  $request->date_start . " 00:00:00")
            ->where("createdOn", "<=",  $request->date_end . " 23:59:59")
            ->orderBy("createdOn","desc")
            ->get();
        // $data = MD::all();


        $data["date_start"] = $request->date_start;
        $data["date_end"] = $request->date_end;
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

 $counter = Counter::find(9);
        $nomor = str_pad($counter->sequence_next_value, 4, 0, STR_PAD_LEFT);
        $arr["no_invoice"] = "R" . str_pad(date("mY") . $nomor, 12, 0, STR_PAD_LEFT);
        $request->merge($arr);
        $data = MD::create($request->all());
        $counter->sequence_next_value += 1;
        $counter->save();
        $response = $this->responseBase($data, 201);
        return $response;

        // $data = MD::create($request->all());
        // $response = $this->responseBase($data, 201);
        // return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MD::with("supplier", "purchase", "detail.stock.item")->find($id);
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
        $line = SupplierReturnLine::where("supplier_return_header_id", "=", $id)->get();
        $total_retur = 0;
        foreach ($line as $item) {
            $total_retur += $item->qty * $item->returprice;
        }
        if ($data->po_id != null) {
            $datapo = POHeader::find($data->po_id);
            $datapurchaseorder = PurchaseInvoiceHeader::where("poheader_id", "=", $datapo->id)->first();
            $datapurchaseorder->retur += $total_retur;
            $datapurchaseorder->invoice_total -= $total_retur;
        }
        if ($data == null) {
            $response = $this->responseBase("Tidak Ada Data", 404);
            return $response;
        } else {
            $data->delete();
            $response = $this->responseBase($data, 200);
            return $response;
        }
        // $data = MD::find($id);
        // if ($data == null) {
        //     $response = $this->responseBase("Tidak Ada Data", 404);
        //     return $response;
        // } else {
        //     $data->delete();
        //     $response = $this->responseBase($data, 200);
        //     return $response;
        // }
    }

    //additional
    function getsorted($field, $sort, $limit)
    {
        $data = MD::select("*");
        $data = $data->orderBy($field, $sort);
        $data = $data->paginate($limit);
        $response = $this->responseBase($data, 200);
        return $response;
    }
}
