@extends("layouts.main")
@section("title")
Stok
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <section class=" table-responsive">
            <form method="get" action="{{url("stok")}}">
                <div class="row">
                    <div class="col-lg-9 offset-3">
                        <div class="float-right">
                            <div class="form-group">
                                <input type="text" placeholder="Nama Barang" name="search" class="form-control"
                                    value="{{$search ?? ""}}">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-info" value="Cari">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <table @if($page==-1 ) id="tabel" @endif class="table table-bordered table-hover box table2excel"
                data-tableName="Report Persediaan Barang Per {{date('d-m-Y')}}">
                <thead>
                    <th class="col-head">
                        No

                    </th>

                    <th class="col-head">
                        Item

                    </th>
                    <th class="col-head">
                        Satuan

                    </th>
                    <th class="col-head">
                        Kuantitas

                    </th>
                    <th class="col-head">
                        Harga Jual
                    </th>
                    <th class="col-head">
                        Harga Beli
                    </th>
                    <th class="col-head">
                        Gudang
                    </th>
                    <th class="col-head">
                        Info
                    </th>

                    <th class="col-head">
                        Action
                    </th>


                </thead>
                <tbody id="item-table">
                    @php
                    $i = 1 + (50 * ($page-1))
                    @endphp
                    @foreach($data->data as $key)
                    <tr>
                        @if($page > 0 )
                        <td class="">{{$i++}}</td>
                        @else
                        <td class="">{{$loop->iteration}}</td>
                        @endif
                        <td>{{$key->inventoryproperty->item->item_name ?? null}}</td>
                        <td>{{$key->satuan->name ?? null}}</td>
                        <td class="">{{$key->qty ?? null}}</td>
                        <td class="printUang">{{$key->sell_price ?? null}}</td>
                        <td class="printUang">{{$key->purchase_price ?? null}}</td>
                        <td>{{$key->warehouse->warehouse_name ?? null}}</td>
                        @if($key->inventoryproperty->threshold_bottom >= $key->qty)
                        <td style="background-color: red"> Segera Restock</td>
                        @else

                        <td> Stock Aman</td>

                        @endif
                        <td>
                            <div id="menutable">
                                <a href="<?php echo url("/") ?>/stok/{{$key->id}}" class="btn btn-warning dis"><i
                                        class="fa fa-eye" aria-hidden="true"></i></a>
                                <a href="<?php echo url("/") ?>/stok/{{$key->id}}/edit" class="btn btn-warning dis"><i
                                        class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'stok')"><i
                                        class="fas fa-trash" aria-hidden="true"></i></button>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            @if($page > 0)
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    Page
                                </div>
                                <div class="mx-2">
                                    <form action="{{ url('stok') }}" method="get">
                                        <select class="custom-select" name="page" onchange="this.form.submit()">
                                            @for($i = 1; $i <= $data->last_page; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $data->current_page ? 'selected' : '' }}>{{ $i }}
                                                </option>
                                                @endfor
                                        </select>
                                    </form>
                                </div>
                                <div>
                                    of {{ $data->last_page }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <form action="{{ url('stok') }}" method="get">
                                <button class="btn btn-dark" name="page" value="{{ $data->current_page - 1 }}"
                                    {{ $data->current_page == 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-chevron-left"></i> Prev
                                </button>
                                <button class="btn btn-success" name="page" value="{{ $data->current_page + 1 }}"
                                    {{ $data->current_page == $data->last_page ? 'disabled' : '' }}>
                                    Next <i class="fas fa-chevron-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section><!-- /.content -->
    </div>
</div>
@endsection