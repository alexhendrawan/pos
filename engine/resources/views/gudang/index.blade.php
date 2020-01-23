@extends("layouts.main")
@section("title")
Gudang
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.min.css') }}">
@endpush

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
                        Alamat
                    </th>
                    <th class="col-head" >
                        Telepon
                    </th>
                    <th class="col-head" >
                        Action
                    </th>

                </thead>
                <tbody id="item-table"> <?php $i = 1; ?>
                    @foreach($data as $key)<tr>
                        <td class="">{{$i++}}</td>
                        <td>{{$key->warehouse_name}}</td>
                        <td>{{$key->warehouse_address}}</td>
                        <td>{{$key->warehouse_phone_no}}</td>
                        <td>
                            <div id="menutable">
                                <a href="<?php echo url("/") ?>/gudang/{{$key->id}}/edit" class="btn btn-warning dis" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'gudang')"><i class="fas fa-trash" aria-hidden="true"></i></button>
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

@push("js")
<script src="{{ asset('assets/vendor/select2/select2.js') }}"></script>
<script type="text/javascript">
    $('.motor').select2({
        selectOnClose: true,
        placeholder: 'Pilih Motor',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/motor',
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $("#selectMotor").change(function () {
        $(".warna").select2({
            selectOnClose: true,
            placeholder: 'Pilih stok',
            ajax: {
                url: "{!! url('/') !!}" + '/ajax/warna/' + $("#selectMotor").val(),
                dataType: 'json',
                delay: 1000,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.warna,
                                id: item.warna
                            }
                        })
                    };
                },
                cache: true
            }
        })
    })
</script>
@endpush
