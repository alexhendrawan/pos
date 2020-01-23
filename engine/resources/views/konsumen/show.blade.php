 @extends("layouts.main")
 @section("title")
 Konsumen
 @endsection
 @section("content")
 <div class="page-content-wrapper">
    <div class="container-fluid">
        <form action="{{url('/')}}/konsumen/{{$data->id}}" method="post">
            @csrf
            @method("put")
            <div class="form-group">
                Nama:
                <input autocomplete="off" type="text" name="name" class="form-control" value="{{$data->name}}" required="">
            </div>

            <div class="form-group">
                Alamat:
                <textarea autocomplete="off" type="text" name="customer_address" class="form-control" required="">{{$data->customer_address}}</textarea>
            </div>

            <div class="form-group">
                Telepon:
                <input autocomplete="off" type="text" name="customer_phone_no" class="form-control" value="{{$data->customer_phone_no}}" required="">
            </div>

            <div class="form-group">
                Salesman:
                <select class="form-control sales" name="sales_id">
                    <option value="{{$data->sales->id}}">{{$data->sales->displayName}}</option>
                </select>

            </div>

            <div class="form-group">
                Kota:
                <select class="form-control city" name="city_id">
                    <option value="{{$data->city->id}}">{{$data->city->city_name}}</option>

                </select>
            </div>

            <div class="form-group">
                <input autocomplete="off" type="hidden" name="loanday" value="30">
            </div>

            <div class="form-group">
                Limit Kredit:<br>
                <input autocomplete="off" type="number" class="form-control" name="creditlimit" value="{{$data->creditlimit}}">
            </div>


            <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Ubah Data!">
        </form>
    </div>
</div>
@endsection

@push("js")
<script type="text/javascript">
  $('.sales').select2({
    selectOnClose: true,
    placeholder: 'Pilih Sales',
    ajax: {
        url: "{!! url('/') !!}" + '/ajax/sales',
        dataType: 'json',
        delay: 1000,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.displayName,
                        id: item.id
                    }
                })
            };
        },
        cache: true
    }
});
  $('.city').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kota',
    ajax: {
        url: "{!! url('/') !!}" + '/ajax/city',
        dataType: 'json',
        delay: 1000,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.city_name,
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