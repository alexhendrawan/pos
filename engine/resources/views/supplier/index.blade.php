@extends("layouts.main")
@section("title")
Supplier
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
                    Kode

                </th>
                <th class="col-head" >
                    Nama

                </th>
                <th class="col-head" >
                    Alamat

                </th>
                <th class="col-head" >
                    Nomor Telepon

                </th>
                <th class="col-head" >
                    Kota

                </th>
                <th class="col-head" >
                    Action
                </th>


            </thead>
            <tbody id="item-table"> <?php $i = 1; ?>
                @foreach($data as $key)<tr>
                    <td class="">{{$i++}}</td>
                    <td>{{$key->suppliercode ?? null}}</td>
                    <td>{{$key->supplier_name}}</td>
                    <td>{{$key->supplier_address}}</td>
                    <td>{{$key->phone_num}}</td>
                    <td>{{$key->city->city_name}}</td>
                    <td>
                       <div id="menutable">
                        <a href="<?php echo url("/") ?>/supplier/{{$key->id}}" class="btn btn-warning dis" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        <button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'supplier')"><i class="fas fa-trash" aria-hidden="true"></i></button>
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