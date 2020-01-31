<?php

namespace App\Http\Controllers;

use App\ItemStock;
use App\StockMutation;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("stockopname.form");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count = $request->count;
        for ($i = 1; $i <= $count; $i++) {
            $itemIDString = "data-item-id-" . $i;
            $qtyString = "data-qty-id-" . $i;
            if ($request->has($itemIDString)) {
                $itemID = $request->$itemIDString;
                $qty = $request->$qtyString;
                $dataStock = ItemStock::find($itemID);

                $mutation = StockMutation::create([
                    "qty_before" => $dataStock->qty,
                    "item_stock_id" => $itemID,
                    "qty" => $qty,
                    "notes" => "Proses - StockOpname",
                ]);
                $dataStock->qty = $qty;
                $dataStock->save();

                $mutation->notes = "Complete - StockOpname";
                $mutation->save();
            }
        }

        return redirect()->back()->with("message", "Stock Opname Berhasil");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
