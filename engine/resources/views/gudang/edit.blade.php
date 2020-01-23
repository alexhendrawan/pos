@extends("layouts.main")
@section("title")
Gudang - {{$data->warehouse_code}}
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <h1>Edit Gudang</h1>
        <section class=" table-responsive">
            <form method="post" action="{{url('/gudang')}}/{{ $data->id }}">
                @method('PUT')
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        Kode:
                        <input autocomplete="off" type="text"  name="warehouse_code" class="form-control" value="{{$data->warehouse_code}}" required="">
                    </div>

                    <div class="form-group">
                        Nama:
                        <input autocomplete="off" type="text"  name="warehouse_name" class="form-control" value="{{$data->warehouse_name}}"  required="">
                    </div>

                    <div class="form-group">
                        Alamat:
                        <input autocomplete="off" type="text"  name="warehouse_address" class="form-control" value="{{$data->warehouse_address}}" required="">
                    </div>

                    <div class="form-group">
                        Telepon:
                        <input autocomplete="off" type="text"  name="warehouse_phone_no" class="form-control" value="{{$data->warehouse_phone_no}}" required="">
                    </div>
                    <div class="form-group">
                        <input autocomplete="off" type="submit" class="form-control btn btn-info" value="Edit">
                    </div>
                </div>
            </form>
        </section><!-- /.content -->
    </div>
    @endsection
