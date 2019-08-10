@extends("layouts.main")
@section("title")
Stok
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <section class=" table-responsive">

         <form action="{{url('/')}}/stok" method="post">
            @csrf
            <div class="form-group">
                Barang
                <select  id="var1" name="item_id" class="inventory form-control" required=""></select>

            </div>

            <div class="form-group">
                Kuantitas:
                <input autocomplete="off" type="text"  id="var5" maxlength="10" name="qty"  class="form-control" required="">
            </div>

            <div class="form-group">
                Harga Beli
                <input autocomplete="off" type="number"  id="var6" name="purchase_price" class="form-control" required="">
            </div>
            <div class="form-group">
                Harga Jual
                <input autocomplete="off" type="number"  id="var6" name="sell_price" class="form-control" required="">
            </div>
            <div class="form-group">
                Satuan
                <select  id="var7" name="satuan_id" class="satuan form-control" required=""></select>
            </div>
            <div class="form-group">
                Gudang
                <select  id="var7" name="warehouse_id" class="warehouse form-control" required=""></select>
            </div>
        </div>
    </div>
    <div class="form-group col-md-4">
        <input autocomplete="off" type="submit" onsubmit="check();" class="form-control btn btn-info dis" value="Create">
    </div>
</form>
</section><!-- /.content -->
</div>
</div>
@endsection
@push("js")
<script type="text/javascript">
    $('.inventory').select2({
        selectOnClose: true,
        placeholder: 'Pilih stok',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/inventoryproperty',
            dataType: 'json',
            delay: 600,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.item.item_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
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