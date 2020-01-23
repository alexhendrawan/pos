@include('report.header')

<section class=" table-responsive">
    <htmlpageheader name="page-header">
    <h4>Laporan Stock Per Tanggal {{date("d-m-Y")}}</h4>
      
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        Your Footer Content
    </htmlpagefooter>
    <table id="tabel" class="table table-bordered table-striped table-hover box" >
        <thead>
            <tr>
                <td>No</td>

                <td>Nama Barang</td>

                <td>Kuantitas</td>

                <td>Satuan</td>

                <td>Harga Modal</td>

                <td>In/out</td>

                <td>Tanggal</td>

                <td>Gudang</td>

                <td>Note</td>


            </tr>
        </thead>
        <tbody>
            @foreach($data as $key)<tr>
                <td class="">{{$loop->iteration}}</td>
                <td>{{$key->item_id->brand_id->name}} {{$key->item_id->item_color_id->name}} {{$key->item_id->item_id->item_name ?? null}}</td>
                <td class="">{{$key->qty ?? null}}</td>
                <td >{{$key->item_stock_id->satuan_id->name ?? null}}</td>
                <td class="printUang">{{$key->item_stock_id->purchase_price ?? null}}</td>
                <td>{{$key->in_out ?? null}}</td>
                <td>{{$key->updatedOn ?? null}}</td>
                <td>{{$key->warehouse_id->warehouse_name ?? null}}</td>
                <td>{{$key->notes ?? null}}</td>

                @endforeach
        </tbody>
    </table>
</section><!-- /.content -->
@include('report.footer')
