  @extends("layouts.main")
  @section("title")
  Karyawan
  @endsection
  @section("content")
  <div class="page-content-wrapper">
    <div class="container-fluid">
     <form method="post" action="{{url('/')}}/user/">
        {{csrf_field()}}
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                Username:
                <input autocomplete="off" type="text"  name="username" class="form-control" >
            </div>

            <div class="form-group">
                Nama:
                <input autocomplete="off" type="text"  name="displayName" class="form-control">
            </div>
            <div class="form-group">
                Alamat:
                <input autocomplete="off" type="text"  name="address" class="form-control" >
            </div>

            <div class="form-group">
                No Telepon/ HP:
                <input autocomplete="off" type="text"  name="telephone" class="form-control" >
            </div>
            <div class="form-group">
                Role:
                <select name="role" class="role form-control" required="">

                </select>
            </div>
            <div class="form-group">
                Password:
                <input autocomplete="off" type="password" name="tes" class="form-control" required="">
            </div>
            <div class="form-group">
                <input autocomplete="off" type="submit" class="form-control btn btn-info" value="Buat Data">
            </div>
        </div>

    </form>
</div>
</div>
@endsection

@push("js")
<script type="text/javascript">
    $('.role').select2({
    selectOnClose: true,
    placeholder: 'Pilih Jabatan',
    ajax: {
        url: "{!! url('/') !!}" + '/ajax/role',
        dataType: 'json',
        delay: 600,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});
</script>
@endpush