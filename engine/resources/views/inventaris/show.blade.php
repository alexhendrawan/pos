@extends("layouts.main")
@section("title")
Inventaris - {{ $data->name }}
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <h1>Edit Inventaris</h1>
                <form action="{{url('inventaris')}}/{{$data->id}}" method="POST">
                  @method('PUT')
                  @csrf
                  <div class="form-group">
                    Nama Inventaris:
                    <input autocomplete="off" type="text"  name="name" id="var1" class="form-control" value="{{$data->name}}" required="">
                </div>
                <div class="form-group">
                    <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Ubah Data!">
                </div>
            </form>


        </div>
    </div>
</div>
</div>
@endsection