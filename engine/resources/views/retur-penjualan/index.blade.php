@extends("layouts.main")
@section("title")
Retur Penjualan
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class=" table-responsive">
			<div class="row">
				<form class="col-md-6" action="{{ url("retur-penjualan") }}">
					<input type="date" name="date_start" value="{{$data->date_start ?? "" }}">
					-
					<input type="date" name="date_end" value="{{ $data->date_end ?? "" }}">
					<input type="submit" name="" value="Submit!">
				</form>
			</div>
			<table id="tabel" class="table table-bordered table-hover box">
				<thead>
					<th class="col-head">No</th>
					<th class="col-head">Tanggal</th>
					<th class="col-head">Customer</th>
					<th class="col-head">Nomor Faktur</th>
					<th class="col-head">Action</th>
				</thead>
				<tbody id="Customer Retur-table"> <?php $i = 1; ?>

					@foreach($data->content as $key)
					<tr>
						<td class="" onclick="detail({{$key->id}},'retur-penjualan')">{{$i++}}</td>
						<td onclick="detail({{$key->id}},'retur-penjualan')">{{$key->createdOn}}</td>
						<td onclick="detail({{$key->id}},'retur-penjualan')">
							{{$key->sales->sales->customer->name ?? "-"}}</td>
						<td onclick="detail({{$key->id}},'retur-penjualan')">{{$key->no_invoice}}</td>
						<td>
							<div id="menutable">
								<a href="<?php echo url("/") ?>/retur-penjualan/{{$key->id}}"
									class="btn btn-xs btn-warning dis" style="width: 100%">Edit</a><br>
								<button class="btn btn-xs btn-danger dis"
									onclick="konfirmasi({{$key->id}},'retur-penjualan')"
									style="width: 100%">Delete</button><br>
								<button onclick="printfaktur({{$key->id}},'retur-penjualan')"
									class="btn btn-xs btn-success " style="width: 100%">Print Faktur</button>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</section><!-- /.content -->
	</div>
</div>
@endsection
