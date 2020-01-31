@extends("layouts.main")
@section("title")
Penerimaan 
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row float-right">
			<a href="{{ url('penerimaan?riwayat=cl') }}" class="btn btn-info">Lunas</a>
			<a href="{{ url('penerimaan?riwayat=c') }}" class="btn btn-success">Belum Lunas</a>
		</div>
		<div class="table-responsive">
			<table id="tabel" class="table table2excel table-bordered table-hover box">
				<thead>
					<th class="col-head">
						No

					</th>
					<th class="col-head">
						No PO

					</th>
					<th class="col-head">
						Supplier

					</th>

					<th class="col-head">
						No Invoice Supplier

					</th>
					<th class="col-head">
						No Invoice

					</th>

					<th class="col-head">
						Status

					</th>
					<th class="col-head">
						Tanggal Invoice

					</th>


					<th class="col-head">
						Total Invoice

					</th>

					<th class="col-head">
						Sisa Bayar

					</th>
					<th class="col-head">
						Total Bayar

					</th>
					<th class="col-head">
						Operator

					</th>
					<th class="col-head">

					</th>


				</thead>
				<tbody id="item-table">
					@php
					$totalhutang = 0;

					@endphp
					@foreach($data as $key)
					@php
					$isi = $key->invoice_total - $key->paid_total;
					if ($isi >= 0) {
					$totalhutang+=$isi;
					} else {
					$isi = 0;
					}
					// $key->sub_total -=$isi;
					@endphp
					<tr>
						<td onclick="detail({{$key -> id}},'penerimaan')">{{$loop->iteration}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')">{{$key->poheader->po_no ?? ""}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')">
							{{$key->poheader->supplier->supplier_name ?? ""}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')">{{$key->supplier_invoice_no}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')">{{$key->internal_invoice_no}}</td>

						<td onclick="detail({{$key -> id}},'penerimaan')">{{$key->purchase_invoice_status}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')">
							{{date("d-m-Y",strtotime($key->invoice_date))}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')" class="printUang">{{$key->invoice_total}}</td>

						<td onclick="detail({{$key -> id}},'penerimaan')" class="printUang">{{$isi}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')" class="printUang">{{$key->paid_total}}</td>
						<td onclick="detail({{$key -> id}},'penerimaan')" class="">{{$key->createdBy}}</td>
						<td class="">
							<a class="btn btn-xs btn-info dis" href="{{url("penerimaan/$key->id/edit")}}">Edit</a>
							<button class="btn btn-xs btn-danger dis" onclick="konfirmasi({{$key->id}},'penerimaan')"
								style="width: 100%">Delete</button></td>
					</tr>
					@endforeach

				</tbody>
			</table>
			<p>
				Total Hutang <span class="printUang" style="text-align: : right">{{$totalhutang}}</span>
			</p>

		</div>
	</div>
</div>
@endsection