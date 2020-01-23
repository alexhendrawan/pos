<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\POHeader as MD;
use App\PurchaseInvoiceHeader;
use App\POLine;
use App\Supplier;
use App\Counter;

class POHeaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MD::with("Supplier", "Warehouse")->orderby('createdOn', 'desc')
            ->where("po_status", "!=", "CL")
            ->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function getByStatus($status)
    {
        $data = MD::with("Supplier", "Warehouse")
            ->orderby('createdOn', 'desc')
            ->where("po_status", "=", $status)
            ->get();
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
        $supplier = Supplier::find($request->supplier_id);
        $nomor = Counter::where("table_name", "=", "po")->first();
        $po_no = "PO/" . $supplier->suppliercode . "/" . date("m") . "/" . date("Y") . "/" . $nomor->sequence_next_value;

        $data = MD::create([
            "po_no" => $po_no,
            "po_status" => "C",
            "supplier_id" => $request->supplier_id,
            "Warehouse_id" => $request->warehouse_id,
            "createdBy" => $request->createdBy
        ]);
        $response = $this->responseBase($data, 201);
        $nomor->sequence_next_value++;
        $nomor->save();
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
        $data = MD::with("Warehouse")->find($id);
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        $response = $this->responseBase($data, 200);
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data = MD::with("Supplier", "Warehouse")->find($id);
        $data["line"] = POLine::with("Satuan", "Stock.Inventoryproperty.Item", "Inventoryproperty.Item", "Inventoryproperty.Category", "Inventoryproperty.Brand")->where("po_header_id", "=", $id)->get();
        if ($data == null) {
            $response = $this->responseBase([], 404);
            return $response;
        }
        $response = $this->responseBase($data, 200);
        return $response;
    }

    public function detailPenerimaan($id)
    {
        $data = MD::with("Warehouse")->find($id);
        $data["line"] = POLine::with("Satuan", "Stock.Inventoryproperty.Item", "Inventoryproperty.Item", "Inventoryproperty.Category", "Inventoryproperty.Brand")->where("po_header_id", "=", $id)->where("penerimaan", "=", 0)->get();
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
        $a = PurchaseInvoiceHeader::where("poheader_id", "=", $id)->first();

        if ($data == null) {
            $response = $this->responseBase("Tidak Ada Data", 404);
            return $response;
        } else {
            if($a !=null){
            $a->delete();
        }
            $data->delete();
            $response = $this->responseBase($data, 200);
            return $response;
        }
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

    public function status($id)
    {
        $data = MD::find($id);
        $data->po_status = "CL";
        $data->save();
        $response = $this->responseBase($data, 200);
        return $response;
    }
}
