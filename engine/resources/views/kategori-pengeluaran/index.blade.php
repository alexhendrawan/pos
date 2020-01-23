@extends("layouts.main")
@section("title")
Kategori
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
                        Nama
                    </th>
                    <th class="col-head" >
                        Action
                    </th>

                </thead>
                <tbody id="item-table"> <?php $i = 1; ?>
                    @foreach($data as $key)<tr>
                        <td class="">{{$i++}}</td>
                        <td>{{$key->name}}</td>
                        <td>
                            <div id="menutable">
                                <a href="<?php echo url("/") ?>/kategoripengeluaran/{{$key->id}}/edit" class="btn btn-warning dis" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'kategoripengeluaran')"><i class="fas fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </section><!-- /.content -->
    </div>
</div>
@endsection
