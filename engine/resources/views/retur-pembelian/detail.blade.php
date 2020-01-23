@extends("layouts.main")
@section("title")
Retur Pembelian Detail
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<h4>Supplier : {{ $data->supplier->supplier_name }}</h4>
				</div>
				<div class="form-group">
					<h4>Nomor Retur: {{ $data->no_invoice }}</h4>
				</div>
			</div>
			<div class="col-md-6">
				
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
					<td>{{ $item->stock->item->item_name ?? "undefined"}}</td>
					<td>{{ $item->qty }}</td>
					<td>{{ number_format($item->retur_price) }}</td>
					<td>{{ number_format($item->qty * $item->retur_price) }}</td>
					<td>
						<div id="menutable">
							<a href="<?php echo url("/") ?>/retur-pembelian-line/{{$item->id}}"
								class="btn btn-xs btn-warning dis" style="width: 100%">Edit</a><br>
							<button class="btn btn-xs btn-danger dis"
								onclick="konfirmasi({{$item->id}},'retur-pembelian-line')"
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
	$('.supplier').select2({
			selectOnClose: true,
			placeholder: 'Pilih Supplier',
			ajax: {
				url: "{!! url('/') !!}" + '/ajax/supplier',
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
