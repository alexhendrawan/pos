<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\PurchaseInvoiceHeader as MD;
use App\PurchaseInvoiceLine;
use App\PurchaseLine;
use App\POLine;
use App\ItemStock;
use App\Counter;
use App\POHeader;

class PurchaseInvoiceHeaderController extends Controller
{

    public function getByStatus($status)
    {
        $data = MD::with("poheader", "poheader.supplier")
            ->where("purchase_invoice_status", "=", $status)
            ->orderby("createdOn", "desc")
            ->get();
        $response = $this->responseBase($data, 200);
        return $response;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MD::with("poheader", "poheader.supplier")
            ->orderby("createdOn", "desc")
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
        $nomor = Counter::where("table_name", "=", "pi")->first();
        $add['internal_invoice_no'] = date("m") . "." . date("Y") . "." . $nomor->sequence_next_value;
        $request->merge($add);
        $data = MD::create($request->all());
        $response = $this->responseBase($data, 201);
        $nomor->sequence_next_value++;
        $nomor->save();

        $poheader = POHeader::find($request->poheader_id);
        $poheader->po_total = $request->invoice_total;
        $poheader->po_total_paid = 0;
        $poheader->save();
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
        $data = MD::with("poheader.supplier","Detail.Warehouse", "Detail.Poline.Inventoryproperty.Item", "Detail.Poline.Satuan")->find($id);
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

        $poheader = POHeader::find($data->poheader_id);
        $poheader->po_total = $request->invoice_total;
        $poheader->save();

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
	        $line = PurchaseInvoiceLine::where("purchase_invoice_header_id","=",$id)->get();
	        foreach ($line as $item) {
	        	$poline = POLine::find($item->po_line_id)->first();
	        	$stock = ItemStock::find($poline->item_stock_id);
	        	$stock->qty -= $item->qty;
	        	$stock->save();
	        	$item->delete();
	        }
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

    public function getSupplier($supplier_id, $search = null)
    {
        $response = $this->responseBase([], 200);
        if ($search == null) {
            $data = MD::select("purchase_invoice_header.*")
                ->leftjoin("po_header", "po_header.id", "=", "purchase_invoice_header.poheader_id")
                ->where("po_header.supplier_id", "=", $supplier_id)
                ->get();
            $response = $this->responseBase($data, 200);
        } else {
            $data = MD::select("purchase_invoice_header.*")
                ->leftjoin("po_header", "po_header.id", "=", "purchase_invoice_header.poheader_id")
                ->where("po_header.supplier_id", "=", $supplier_id)
                ->where("purchase_invoice_header.internal_invoice_no", "like", "%" . $search . "%")
                ->get();
            $response = $this->responseBase($data, 200);
        }
        return $response;
    }

    public function editByPO($po_id, Request $request)
    {
        $data = MD::where("poheader_id", "=", $id)->first();
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
}
