@extends("layouts.main")
@section("title")
Merk - {{$data->name}}
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <h1>Edit Gudang</h1>
        <section class=" table-responsive">
            <form method="post" action="{{url('/merk')}}/{{ $data->id }}">
                @method('PUT')
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        Nama:
                        <input autocomplete="off" type="text"  name="name" class="form-control" value="{{$data->name}}"  required="">
                    </div>
                    <div class="form-group">
                        <input autocomplete="off" type="submit" class="form-control btn btn-info" value="Edit Data">
                    </div>
                </div>
            </form>
        </section><!-- /.content -->
    </div>
    @endsection
