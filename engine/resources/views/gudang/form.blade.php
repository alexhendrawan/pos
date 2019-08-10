@extends("layouts.main")
@section("title")
Gudang
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <section class=" table-responsive">
         <form action="{{url('/')}}/gudang" method="post">
            @csrf
            <div class="form-group">
                Kode:
                <input autocomplete="off" required="true" name="warehouse_code" type="text"  id="kode" class="form-control" >
            </div>

            <div class="form-group">
                Nama:
                <input autocomplete="off" required="true" type="text"  name="warehouse_name" id="nama" class="form-control" >
            </div>

            <div class="form-group">
                Alamat:
                <input autocomplete="off" type="text"  id="alamat" name="warehouse_address" class="form-control" required="">
            </div>

            <div class="form-group">
                Telepon:
                <input autocomplete="off" type="text"  id="telepon" name="warehouse_phone_no" class="form-control" required="">
            </div>

            <div class="form-group">
                <input autocomplete="off" type="submit" class="form-control btn btn-success dis" value="Buat Data">
            </div>
        </form>
    </section><!-- /.content -->
</div>
</div>
@endsection
