<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class POLineController extends Controller
{
    
    public function store(Request $request)
    {
        $response = $this->post("po-header",$request->all());
        for ($i = 1; $i <= $request->count; $i++) {
            if($request->has("data-item-id-" . $i)){

              $new['po_header_id'] = $response['data']->id;
              $stringrequest = "data-item-id-" . $i;
              $new['inventory_property_id'] = $request->$stringrequest;
              $stringrequest = "data-qty-id-" . $i;
              $new['qty_buy'] = $request->$stringrequest;
              $new['qty_get'] = 0;

              $stringrequest = "data-unit-id-" . $i;
              $new['satuan_id'] = $request->$stringrequest;
              $request->merge($new);
            // dd($new);
              $this->post("po-line", $new);

          }
      }
      return redirect()->back()->with('message', "Data dibuat dengan nomor ".$response['data']->po_no."  Lakukan Penerimaan <a target='_BLANK' href=".url('/')."/penerimaan/".$response['data']->id.'/create'.">Klik Disini</a>");
  }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->get("po-line/$id");
        return view("PO-detail.index",$response);
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
        $response = $this->put("po-line/$id",$request->all());
        return redirect()->back();
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
