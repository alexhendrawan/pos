@extends("layouts.main")
@section("title")
Kategori
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <section class=" table-responsive">
         <form action="{{url('/')}}/kategori" method="post">
            @csrf
            <div class="form-group">
                Nama:
                <input autocomplete="off" required="true" type="text"  name="name" id="nama" class="form-control" >
            </div>
            <div class="form-group">
                <input autocomplete="off" type="submit" class="form-control btn btn-success dis" value="Buat Data">
            </div>
        </form>
    </section><!-- /.content -->
</div>
</div>
@endsection
