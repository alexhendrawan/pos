  
@extends("layouts.main")
@section("title")
Barang
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
                    Edit
                </th>

                <th class="col-head" >
                    Delete
                </th>
                

            </thead>
            <tbody id="item-table"> <?php $i = 1; ?>
                @foreach($data as $key)<tr>
                    <td class="">{{$i++}}</td>

                    <td>{{$key->item_code}}</td>
                    <td>{{$key->item_name}}</td>

                    <td><a href="<?php echo url("/") ?>/barang/{{$key->id}}" class="btn btn-warning dis" >Edit</a></td>
                    <td><button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'barang')">Delete</button>
                    </td></tr>
                    @endforeach

                </tbody>
            </table>
        </section><!-- /.content -->
    </div>
</div>
@endsection
