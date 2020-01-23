 @extends("layouts.main")
 @section("title")
 Karyawan
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
                        Username

                    </th>

                    <th class="col-head" >
                        Nama

                    </th>
                    <th class="col-head" >
                        Alamat

                    </th>
                    <th class="col-head" >
                        Telepon/No Hp

                    </th>

                    <th class="col-head" >
                        Jabatan

                    </th>
                    <th class="col-head" >


                    </th>


                </thead>
                <tbody id="item-table"> 
                    @foreach($data as $key)
                    <tr>
                        <td class="">{{$loop->iteration}}</td>
                        <td>{{$key->username ?? null}}</td>
                        <td>{{$key->displayName ?? null}}</td>
                        <td>{{$key->address ?? null}}</td>
                        <td>{{$key->telephone ?? null}}</td>
                        <td>{{$key->role->name ?? null}}</td>

                        <td>  
                            <div id="menutable">
                                <a href="<?php echo url("/") ?>/karyawan/{{$key->id}}" class="btn btn-warning dis" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                                <button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'karyawan')"><i class="fas fa-trash" aria-hidden="true"></i></button>
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