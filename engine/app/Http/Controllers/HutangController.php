<?php

namespace App\Http\Controllers;

use App\POHeader;
use App\PurchaseInvoiceHeader;
use App\PurchaseInvoicePayment;
use Illuminate\Http\Request;

class HutangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = $this->get("purchase-invoice-payment");
        // dd($data["data"][0]);
        return view("hutang.index", $this->get("purchase-invoice-payment"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("hutang.form", $this->get("purchase-invoice-header"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = $this->post("purchase-invoice-payment", $request->all());
        return redirect()->back()->with("message", "Lunas");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = PurchaseInvoicePayment::with("purchaseinvoiceheader.poheader.supplier")
            ->where("purchase_invoice_header_id", $id)
            ->get();

        return view("pembayaran.hutang", compact("data"));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function markfordelete()
    {
        $PO = PurchaseInvoiceHeader::with("payment")->get();
        foreach ($PO as $purchase) {

            foreach ($purchase->payment as $payment) {
                $compare = PurchaseInvoicePayment::where('purchase_invoice_header_id', $payment->purchase_invoice_header_id)
                    ->where("payment_value", $payment->payment_value)
                    ->whereDate("createdOn", $payment->createdOn)
                    ->get();
                if (count($compare) > 1) {
                    $count = count($compare);
                    for ($i = 1; $i < $count; $i++) {
                        $id = $compare[$i]->purchase_invoice_header_id;
                        $minus = $compare[$i]->payment_value;
                        $pi = PurchaseInvoiceHeader::where("id", $id)->first();
                        $pi->paid_total -= $minus;
                        $pi->save();
                        $poheader = POHeader::where("id", $pi->poheader_id)->first();
                        $poheader->po_total_paid -= $minus;
                        $poheader->save();
                        $compare[$i]->delete();
                    }
                }
            }

        }
    }
}
