@extends("layouts.main")
@section("title")
Retur Pembelian
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class="table-responsive">
			<div class="row ">
				<form class="col-md-6 float-right" action="{{ url("retur-pembelian") }}">
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
					<th class="col-head">Supplier</th>
					<th class="col-head">Nomor Faktur</th>
					<th class="col-head">Action</th>
				</thead>
				<tbody id="Customer Retur-table"> <?php $i = 1; ?>

					@foreach($data->content as $key)
					<tr>
						<td class="" onclick="detail({{$key->id}},'retur-pembelian')">{{$i++}}</td>
						<td onclick="detail({{$key->id}},'retur-pembelian')">{{$key->createdOn}}</td>
						<td onclick="detail({{$key->id}},'retur-pembelian')">{{$key->supplier->supplier_name ?? "-"}}
						</td>
						<td onclick="detail({{$key->id}},'retur-pembelian')">{{$key->no_invoice}}</td>
						<td>
							<div id="menutable">
								<a href="<?php echo url("/") ?>/retur-pembelian/{{$key->id}}" class="btn btn-xs btn-warning dis" style="width: 100%">Edit</a><br>
								<button class="btn btn-xs btn-danger dis" onclick="konfirmasi({{$key->id}},'retur-pembelian')" style="width: 100%">Delete</button><br>
								<button onclick="printfaktur({{$key->id}})" class="btn btn-xs btn-success " style="width: 100%">Print Faktur</button>
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
