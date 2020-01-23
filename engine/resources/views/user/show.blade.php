  @extends("layouts.main")
  @section("title")
  Karyawan
  @endsection
  @section("content")
  <div class="page-content-wrapper">
    <div class="container-fluid">
     <form method="post" action="{{url('/')}}/user/{{$data->id}}">
        @csrf
        @method("PUT")
        <div class="col-md-12 col-xs-12">
            <div class="form-group">
                Username:
                <input autocomplete="off" type="text"  name="username" class="form-control" value="{{$data->username}}" >
            </div>

            <div class="form-group">
                Nama:
                <input autocomplete="off" type="text"  name="displayName" class="form-control" value="{{$data->displayName ?? null}}" >
            </div>
            <div class="form-group">
                Alamat:
                <input autocomplete="off" type="text"  name="address" class="form-control" value="{{$data->address ?? null}}" >
            </div>

            <div class="form-group">
                No Telepon/ HP:
                <input autocomplete="off" type="text"  name="telephone" class="form-control" value="{{$data->telephone ?? null}}" >
            </div>
            <div class="form-group">
                Role:
                <select name="role" class="role form-control" required="">

                </select>
            </div>
            <div class="form-group">
                Password Lama:
                <input autocomplete="off" type="password" name="tes" class="form-control" required="">
            </div>

            <div class="form-group">
                Password Baru (Jika tidak ingin mengganti password, isikan password lama anda):
                <input autocomplete="off" type="password" name="password" class="form-control" required="">
            </div>
            <div class="form-group">
                <input autocomplete="off" type="submit" class="form-control btn btn-info" value="Ubah Data!">
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
        delay: 1000,
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