@extends("layouts.main")
@section("title")
Supplier - {{ $data->supplier_name }}
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <h1>Edit Supplier</h1>
                <form action="{{url('supplier')}}/{{$data->id}}" method="POST">
                  @method('PUT')
                  @csrf
                  <div class="form-group">
                    Kode:
                    <input autocomplete="off" type="text"  name="suppliercode" id="var1" class="form-control" value="{{$data->suppliercode}}" required="">
                </div>
                <div class="form-group">
                    Nama:
                    <input autocomplete="off" type="text"  name="supplier_name" id="var2" class="form-control" value="{{$data->supplier_name}}" required="">
                </div>
                <div class="form-group">
                    Alamat:
                    <textarea autocomplete="off" type="text"  name="supplier_address" id="var3" class="form-control" required="">{{$data->supplier_address}}</textarea>
                </div>
                <div class="form-group">
                    Nomor Telepon:
                    <input autocomplete="off" type="text"  name="phone_num" id="var4" class="form-control" value="{{$data->phone_num}}" required="">
                </div>
                <div class="form-group">
                    Kota:
                    <select class="form-control city" name="city_id" id="var5">
                        <option selected value="{{$data->city->id}}">{{$data->city->type}} {{$data->city->city_name}}</option>
                    </select>
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

@push("js")
<script type="text/javascript">
 $('.city').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kota',
    ajax: {
        url: "{!! url('/') !!}" + '/ajax/city',
        dataType: 'json',
        delay: 600,
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