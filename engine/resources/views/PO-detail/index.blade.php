@extends("layouts.main")
@section("title")
Pembelian
@endsection
@section("content")
<div class="page-content-wrapper">
  <div class="container-fluid">
    @if($data->penerimaan==0)
    
    <form action="{{ url('/')."/po-line/".$data->id }}" method="post">
      @csrf
      @method("PUT")
      <div class="form-group">
        Barang:
        <select type="text" id="var3" class="inventory form-control">
          <option value="{{ $data->inventoryproperty->id }}">{{ $data->inventoryproperty->item->item_name }}</option>
        </select>

      </div>

      <div class="form-group">
        QTY Beli:
        <input autocomplete="off" type="text" id="var5" class="form-control" value="{{ $data->qty_buy }}">
      </div>

      <div class="form-group">
        <input type="submit" class="form-control btn btn-info" value="Edit">
      </div>
      @else
      Penerimaan sudah dilakukan, tidak bisa edit data PO ini
      @endif
    </form>
  </div>
</div>
@endsection
@push("js")
<script type="text/javascript">

  $('.inventory').select2({
    selectOnClose: true,
    placeholder: 'Pilih Barang',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/inventoryproperty',
      dataType: 'json',
      delay: 1000,
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
  $(".inventory").change(function () {
    $.ajax({
      url: "{!! url('/') !!}" + '/ajax/item_stock/inven/'+$(".inventory").val(), 
      method: "get",
      success: function (response) {
        var newOption = new Option(response["name"], response["id"], true, true);
        $('.satuan').append(newOption).trigger('change');
      },
      error: function (xhr, statusCode, error) {
      }
    });
  });

  $('.satuan').select2({
    selectOnClose: true,
    placeholder: 'Pilih Satuan',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/satuan',
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