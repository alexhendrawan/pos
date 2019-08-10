@extends("layouts.main")
@section("title")
Stok - {{$data->inventoryproperty->item->item_name}}
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <h1>Edit Barang</h1>
        <form action="{{url('/')}}/stok/{{$data->id}}" method="post">
            @csrf
            @method("PUT")
            <div class="form-group">
                Jumlah QTY:
                <span>{{$data->qty}} {{$data->satuan->name}}</span> 
            </div>

            <div class="form-group">
            Jumlah Sekarang</i>
            <input autocomplete="off" type="number" name="qty" class="form-control" value="{{$data->qty}}">
        </div>
        <div class="form-group">
            Harga Beli
            <input autocomplete="off" type="number" name="purchase_price" value="{{$data->purchase_price}}" class="form-control" required="">
        </div>
        <div class="form-group">
            Harga Jual
            <input autocomplete="off" type="number" name="sell_price" value="{{$data->sell_price}}" class="form-control" required="">
        </div>
        <div class="form-group">
            Satuan:
            <select name="satuan_id" id="unit" class="form-control satuan">
                <option value="{{$data->satuan->id}}">{{$data->satuan->name}}</option>
            </select>
        </div>
        <div class="form-group">
            Gudang
            <select name="warehouse_id" class="warehouse form-control">
                <option value="{{$data->warehouse->id}}">{{$data->warehouse->warehouse_name}}</option>

            </select>
        </div>


    </div>
</div>
<div class="form-group col-md-4">
    <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Create">
</div>
</form>
</div>
@endsection

@push("js")
<script type="text/javascript">
   
    $('.warehouse').select2({
        selectOnClose: true,
        placeholder: 'Pilih Gudang',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/gudang',
            dataType: 'json',
            delay: 600,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.warehouse_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
      $('.satuan').select2({
        selectOnClose: true,
        placeholder: 'Pilih Satuan',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/satuan',
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
