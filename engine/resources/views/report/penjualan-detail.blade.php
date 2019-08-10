@include('report.header')
<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Laporan Penjualan Per Tanggal {{date("d-m-Y")}}</h4>

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
                      Tanggal Pembuatan

                    </td>
                    <td class="col-head" >
                        No Sales Internal

                    </td>
                    <td class="col-head" >
                        Pembeli
                    </td>

                    <td class="col-head" >
                        Tanggal Order

                    </td>
                    <td class="col-head" >
                        Tenggat Waktu

                    </td>

                    <td class="col-head" >
                        Total Tagihan

                    </td>


                    <td class="col-head" >
                        Total Bayar

                    </td>

                    <td class="col-head" >
                        Sisa Bayar

                    </td>


                </tr>

            </thead>
  

            <tbody id="item-table">
              @php
              $totalhutang = 0;
              @endphp
              @foreach($data as $key)
              <?php
              $isi = $key->sales_order_header_id->payment_remain;
              if ($isi >= 0) {
                $totalhutang+=$isi;
            } else {
                $isi = 0;
            }
                    // $key->sub_total -=$isi;
            ?>
            <tr onclick="({{$key->id}})">
                <td class="">{{$loop->iteration}}</td>
                <td>{{$key->createdOn}}</td>
                <td>{{$key->internal_invoice_no}}</td>
                <td>{{$key->customer_id->name}}</td>
                <td>{{$key->sales_order_header_id->order_date}}</td>
                <td>{{$key->sales_order_header_id->due_date}}</td>
                <td class="printUang">{{$key->sales_order_header_id->total_sales}}</td>
                <td class="printUang">{{$key->sales_order_header_id->total_paid}}</td>
                <td class="printUang">{{$key->sales_order_header_id->payment_remain}}</td>
            </tr>
            <tr>
                <td colspan=""></td>
                <td colspan=""></td>
                <td colspan=""></td>
                <td colspan=""></td>

                <td class="col-head" >
                    No

                </td>
                <td class="col-head" >
                    Item

                </td>
                <td class="col-head" >
                    Satuan

                </td>

                <td class="col-head" >
                    Qty

                </td>

                <td class="col-head" >
                    Qty Belum Kirim

                </td>

                <td class="col-head" >
                    Harga

                </td>
            </tr>
            <?php
            $lineid = "id".$key->id;
            ?>

            @foreach($line->$lineid->data as $key)<tr>
                <tr>
                    <td colspan=""></td>
                    <td colspan=""></td>
                    <td colspan=""></td>
                    <td colspan=""></td>

                    <td>{{$key->sales_order_header_id->id}}</td>
                    <td>{{$key->item_stock_id->item->brand_id->name}} {{$key->item_stock_id->item->item_color_id->name}} {{$key->item_stock_id->item->item_id->item_name}}</td>

                    <td>{{$key->item_stock_id->satuan_id->name ?? null}}</td>
                    <td class="">{{$key->qty}}</td>
                    <td class="">{{$key->qty_pending_send}}</td>
                    <td class="printUang">{{$key->item_stock_id->purchase_price}}</td>
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
                    <td></td>
                    <td class="printUang">{{$totalhutang}}</td>
                    <td></td>
                </tbody>
            </table>
        </section><!-- /.content -->
        @include('report.footer')
