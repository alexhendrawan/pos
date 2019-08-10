@extends("layouts.main")
@section("title")
Retur Penjualan Detail
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<h4>Konsumen : {{ $data->customer->name }}</h4>
				</div>
				<div class="form-group">
					<h4>Nomor Retur: {{ $data->no_invoice }}</h4>
				</div>
			</div>
			<div class="col-md-6">
				<h4>Nomor Penjualan: <a href="{{ url("penjualan")."/".$data->sales->sales->id }}" class="btn btn-info">{{ $data->sales->sales->intnomorsales }}</a></h4>
			</div>
		</div>
		<table class="table table-bordered table-stripped">
			<thead>
				<th>No</th>
				<th>Barang</th>
				<th>QTY</th>
				<th>Harga</th>
				<th>Total</th>
				<th>Action</th>
			</thead>
			<tbody>
				@foreach($data->detail as $item)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $item->stock->inventoryproperty->item->item_name }}</td>
					<td>{{ $item->qty }}</td>
					<td>{{ number_format($item->returprice) }}</td>
					<td>{{ number_format($item->qty * $item->returprice) }}</td>
					<td>
						<div id="menutable">
							<a href="<?php echo url("/") ?>/retur-penjualan-line/{{$item->id}}"
								class="btn btn-xs btn-warning dis" style="width: 100%">Edit</a><br>
								<button class="btn btn-xs btn-danger dis"
								onclick="konfirmasi({{$item->id}},'retur-penjualan-line')"
								style="width: 100%">Delete</button><br>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	@endsection

	@push("js")
	<script type="text/javascript">
		$('.customer').select2({
			selectOnClose: true,
			placeholder: 'Pilih Konsumen',
			ajax: {
				url: "{!! url('/') !!}" + '/ajax/customer',
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