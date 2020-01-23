@include('report.header')
<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Laporan Pembelian Per Tanggal {{date("d-m-Y")}}</h4>

    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        Your Footer Content
        </htmlpagefooter>
        <table id="tabel" class="table table-bordered table-hover box">
            <thead>
                <tr>
                   <td class="col-head" >
                    No

                </td>
                <td class="col-head" >
                    Supplier

                </td>

                <td class="col-head" >
                    No Invoice Supplier

                </td>
                <td class="col-head" >
                    No Invoice Internal

                </td>

                <td class="col-head" >
                    Status

                </td>
                <td class="col-head" >
                    Tanggal Invoice

                </td>


                <td class="col-head" >
                    Total Invoice

                </td>

                <td class="col-head" >
                    Sisa Bayar

                </td>
                <td class="col-head" >
                    Total Bayar

                </td>
            </tr>

        </thead>

        <tbody id="item-table">

          @php
          $totalhutang = 0;
          @endphp
          @foreach($data as $key)
          <?php
          $isi = $key->invoice_total - $key->paid_total;
          if ($isi >= 0) {
            $totalhutang+=$isi;
        } else {
            $isi = 0;
        }
                    // $key->sub_total -=$isi;
        ?>
        <tr onclick="({{$key -> id}})">
            <td class="">{{$loop->iteration}}</td>
            <td>{{$key->poheader->supplier_code->supplier_name}}</td>
            <td>{{$key->supplier_invoice_no}}</td>
            <td>{{$key->internal_invoice_no}}</td>

            <td>{{$key->purchase_invoice_status}}</td>
            <td>{{$key->invoice_date}}</td>
            <td class="printUang">{{$key->invoice_total}}</td>

            <td class="printUang">{{$isi}}</td>
            <td class="printUang">{{$key->paid_total}}</td>
        </tr>
        <tr>
           <td></td>
           <td></td>

           <td class="col-head" >
            Nomor PO

        </td>
        <td class="col-head" >
          No

        </td>
        <td class="col-head" >
            Cabang

        </td>
        <td class="col-head" >
            Item

        </td>

        <td class="col-head" >
            Unit

        </td>
        <td class="col-head" >
            QTY

        </td>
        <td class="col-head" >
            Harga per Unit

        </td>


    </tr>
    <?php
    $lineid = "id".$key->id;
    ?>

    @foreach($line->$lineid->data as $key)<tr>

       <td></td>
       <td></td>
       <td>{{$key->po_line_id->pid->po_no ?? null}}</td>
       <td>{{$key->po_line_id->id ?? null}}</td>
       <td>{{$key->po_line_id->pid->branch->branchCode ?? null}}</td>
       <td>{{$key->po_line_id->item_id->brand_id->name ?? null}} {{$key->po_line_id->item_id->item_color_id->name ?? null}} {{$key->po_line_id->item_id->item_id->item_name ?? null}}</td>
       <td>{{$key->po_line_id->satuan_id->name ?? null}}</td>
       <td class="">{{$key->qty ?? null}}</td>
       <td class="printUang">{{$key->price_per_Satuan_id ?? null}}</td>
   </tr>
   @endforeach

   @endforeach
   <tr class="">
    <td>Total Hutang</td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td class="printUang">{{$totalhutang}}</td>
    <td></td>

</tr>

</tbody>
</table>
</section><!-- /.content -->
@include('report.footer')
