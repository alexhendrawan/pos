 @extends("layouts.main")
 @section("title")
 Pembelian Detail
 @endsection
 @section("content")
 <div class="page-content-wrapper">
  <div class="container-fluid">
    <section class=" table-responsive">
       <table id="tabel" class="table table-bordered table-hover box">
        <thead>
            <th class="col-head" >
                No

            </th>

            <th class="col-head" >
                No PO

            </th>
            <th class="col-head" >
                Barang

            </th>
            <th class="col-head" >
                Kategori

            </th>
            <th class="col-head" >
                QTY Beli

            </th>
            <th class="col-head" >
                QTY Dapat

            </th>
            <th class="col-head" >
                Unit

            </th>

            <th class="col-head" >
               Action

           </th>

       </thead>
       <tbody id="item-table"> 
        @foreach($data->line as $key)
        <tr>
            <td class="">{{$loop->iteration}}</td>
            <td>{{$data->po_no}}</td>
            <td>{{$key->inventoryproperty->item->item_name}}</td>
            <td>{{$key->inventoryproperty->category->name}}</td>
            <td class="">{{$key->qty_buy}}</td>
            <td class="">{{$key->qty_get}}</td>
            <td>{{$key->satuan->name}}</td>
            <td>
                <div id="menutable">
                    @if($key->penerimaan == 0)
                    <a href="<?php echo url("/") ?>/po-line/{{$key->id}}" class="btn btn-xs btn-warning dis"  style="width: 100%">Edit</a>
                    <button class="btn btn-xs btn-danger dis" onclick="konfirmasi({{$key->id}},'po-line')" style="width: 100%">Delete</button>
                    @else
                    Penerimaan Sudah Dilakukan
                    @endif

                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</section>
</div>
</div>
@endsection