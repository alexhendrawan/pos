@extends("layouts.main")
@section("title")
Penjualan Detail 
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
	
		<div class="row">
			<form action="{{url('/')}}/penjualan-detail/{{$data->id}}" method="post">
				@csrf
				@method("put")
				<div class="form-group">
					Barang:
					<select id="var3" name="item_stock_id" class="stock form-control" style="width: 100%">
						<option value="{{$data->stock->id}}">{{$data->stock->inventoryproperty->item->item_name}}</option>
					</select>
				</div>
				<div class="form-group">
					Harga Satuan:
					<input autocomplete="off" type="number" name="price_per_satuan_id" id="var10" class="form-control" value="{{$data->price_per_satuan_id}}">
					Harga Modal
					<input autocomplete="off" type="number" disabled id="var20" class="form-control" value="{{$data->stock->purchase_price}}">
				</div>
				<div class="form-group">
					Diskon (%):
					<input autocomplete="off" type="number" name="diskon" id="var11" class="form-control" value="{{ $data->diskon }}">
				</div>
				<div class="form-group">
					QTY Buy:
					<input autocomplete="off" type="text" id="var5" name="qty" value="{{$data->qty}}" class="form-control">
				</div>
				<div class="form-group ">
					<input  type="submit" class="form-control btn btn-info dis" value="Edit Barang">
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push("js")
<script type="text/javascript">
	$('.stock').select2({
		selectOnClose: true,
		placeholder: 'Pilih stok',
		ajax: {
			url: "{!! url('/') !!}" + '/ajax/itemstock',
			dataType: 'json',
			delay: 1000,
			processResults: function (data) {
				return {
					results: $.map(data.data, function (items) {
						return {
							text: items.inventoryproperty.item.item_name,
							id: items.id
						}
					})
				};
			},
			cache: true
		}
	});

	$(".stock").change(function () {
		$.ajax({
			url: "{!! url('/') !!}" + "/ajax/itemstock/" + $(".stock").val(),
			method: "get",
			success: function (response) {
				$("#var10").val(response["sell_price"]);
				$("#var20").val(response["purchase_price"]);
				$("#sell_price").val(response["sell_price"]);
				$("#buyprice").val(response["purchase_price"]);
				if(response["qty"] <= 0){
					swal("Jumlah Stock 0. Harap melakukan pembelian terlebih dahulu");
				}else{
				}
			},
			error: function (xhr, statusCode, error) {
			}
		});
	});
</script>
@endpush