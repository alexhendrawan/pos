 @extends("layouts.main")
 @section("title")
 Konsumen
 @endsection
 @section("content")
 <div class="page-content-wrapper">
    <div class="container-fluid">
      <table id="tabel" class="table table-bordered table-hover box">
        <thead>
            <th class="col-head">No</th>
            <th class="col-head">Kode</th>
            <th class="col-head">Nama</th>
            <th class="col-head">Alamat</th>
            <th class="col-head">Kota</th>
            <th class="col-head">Sales</th>
            <th class="col-head">Telepon</th>
            <th class="col-head">Limit</th>
            <th class="col-head">Edit</th>
            <th class="col-head">Delete</th>
        </thead>
        <tbody id="item-table"> <?php $i = 1; ?>
            @foreach($data as $key)<tr>
                <td>{{$i++}}</td>
                <td>{{$key->customer_code ?? null}}</td>
                <td>{{$key->name}}</td>
                <td>{{$key->customer_address}}</td>
                <td>{{$key->city->city_name}}</td>
                <td>{{$key->sales->displayName ?? "-"}}</td>
                <td>{{$key->customer_phone_no}}</td>
                <!-- <td>{{$key->loanday}}</td> -->
                <td class="printUang">{{$key->creditlimit}}</td>
                <td><a href="<?php echo url("/") ?>/konsumen/{{$key->id}}" class="btn btn-warning dis" >Edit</a></td>
                <td><button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'konsumen')">Delete</button></td></tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>
@endsection