@extends("layouts.main")
@section("title")
Inventaris
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <h1>Inventaris</h1>
                <form action="{{url('inventaris')}}" method="POST">
                  @csrf
                  <div class="form-group">
                    Nama Inventaris:
                    <input autocomplete="off" type="text"  name="name" id="var1" class="form-control" value="" required="">
                </div>
                <div class="form-group">
                    <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Buat Data!">
                </div>
            </form>


        </div>
    </div>
</div>
</div>
@endsection