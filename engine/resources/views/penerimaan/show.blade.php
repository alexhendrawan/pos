@extends("layouts.main")
@section("title")
Penerimaan
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<form action="{{url('/')}}/penerimaan" method="post">
			@csrf
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						Nomor Faktur Supplier:
						<h4>{{ $data->supplier_invoice_no }}</h4>
					</div>

					<div class="form-group">
						Tanggal Faktur:
						<h4>{{ $data->invoice_date }}</h4>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						Nilai Faktur:
						<h4>Rp {{ number_format($data->invoice_total) }}</h4>
					</div>
					<div class="form-group">
						Dibayar
						<h4>{{ $data->paid_total }}</h4>
					</div>
				</div>
			</div>

			<div class="col-md-12 box">
				<div class="col-md-12" id="bbb" style="height: 300px; overflow-y: auto">
					<table id="" class="table table-bordered table-stripped">
						<thead>
							<th>No.</th>
							<th>Barang</th>
							<th>QTY Buy</th>
							<th>QTY Get</th>
							<th>Harga Beli per Barang</th>
							<th>Harga Jual per Barang</th>
							<th>Gudang</th>

						</thead>
						<tbody id="myTable">
							@foreach($data->detail as $key)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$key->poline->inventoryproperty->item->item_name}}</td>
								<td>{{$key->poline->qty_buy}} {{$key->poline->satuan->name}}</td>
								<td>{{$key->poline->qty_get}} {{$key->poline->satuan->name}}</td>
								<td>{{$key->price_per_satuan_id ?? 0}}</td>
								<td>{{$key->sell_per_satuan_id?? 0}}</td>
								<td>
									{{$key->warehouse->warehouse_name}}
								</td>

							</tr>
							{{-- <input readonly type="hidden" name="data-line-id-{{$loop->iteration}}"
							id="data-line-id-{{$loop->iteration}}" value="{{$key->id}}"> --}}
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@push("js")
<script type="text/javascript">
	calculatetotal();
    function calculatetotal() {
        $("#nilaifak").val(0);
        for (var i = 1; i <= $(".count").val(); i++) {
            var harga = $("#pp-get-" + i).val();
            var qty = $("#qty-get-" + i).val();
            var sebelum = $("#nilaifak").val();
            $("#nilaifak").val(parseInt(sebelum) + (parseInt(harga) * parseInt(qty)));
        }
    }

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
</script>

@endpush
