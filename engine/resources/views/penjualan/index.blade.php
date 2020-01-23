@extends("layouts.main")
@section("title")
Penjualan
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class="row">

			<form class="col-md-6" action="{{ url("penjualan") }}">
				<input type="date" name="date_start" value="{{$data->date_start ?? "" }}">
				-
				<input type="date" name="date_end" value="{{ $data->date_end ?? "" }}">
				<input type="submit" name="" value="Submit!">
			</form>
			<form class="col-md-6" action="{{ url("penjualan/search") }}" method="get">
				<label for="key">
					Search By
					<select name="key" class="form-control" id="key">
						<option value="customer.name">Customer</option>
						<option value="sales_order_header.intnomorsales">Nomor Faktur</option>
					</select>
				</label>
				<label for="search">
					Query
					<input type="text" autocomplete="off" class="form-control" name="search" id="search"
						value="{{ app('request')->input('search') ?? "" }}">
				</label>
				<input type="submit" name="" value="Submit!">
			</form>

			<div class="card">
				<div class="card-body">
					<div class="table-responsive">
						<table id="tabel" class="table table-bordered table-hover box">
							<thead class="replicate">
								<th class="col-head">
									No

								</th>
								<th class="col-head">
									No Sales

								</th>

								<th class="col-head">
									Customer

								</th>

								<th class="col-head">
									Tanggal Order

								</th>
								<th class="col-head">
									Total Faktur <i class="fa fa-question-circle" data-toggle="tooltip"
										data-placement="top" title="Sudah dikurangi Retur dan Diskon"></i>

								</th>
								<th class="col-head">
									Total Bayar <i class="fa fa-question-circle" data-toggle="tooltip"
										data-placement="top" title="Total Yang sudah dibayarkan"></i>

								</th>
								<th class="col-head">
									Retur
								</th>
								<th class="col-head">
									Sisa Bayar <i class="fa fa-question-circle" data-toggle="tooltip"
										data-placement="top" title="Sudah dikurangi Retur dan Diskon"></i>

								</th>
								<th class="col-head d-none">
									Sisa Bayar
								</th>
								<th class="col-head">
									Status Pengiriman
								</th>
								<th class="col-head">
									Operator

								</th>
								<th>
									Action
									<i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
										title="Baris Berwarna Abu Belum Print"></i>
								</th>
							</thead>

							<tbody id="item-table">
								@forelse($data->content as $key)

								<tr @if($key->sales->print == 0) style="color: red !important" @endif
									>
									<td onclick="detail ({{$key->sales->id}},'penjualan')" class="">{{$loop->iteration}}
									</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')">
										{{$key->sales->intnomorsales}}</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')" style="width:100px">
										{{$key->sales->customer->name}}</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')">{{$key->sales->createdOn}}
									</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')" class="printUang"
										style="width: 150px">
										{{$key->sales->total_sales}}</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')" class="printUang"
										style="width: 150px">
										{{$key->sales->total_paid}}</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')" class="printUang"
										style="width: 150px">
										{{$key->sales->retur}}</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')" class="printUang"
										style="width: 150px">
										{{$key->sales->payment_remain}}</td>
									<td class="d-none" onclick="detail ({{$key->sales->id}},'penjualan')" class="">
										{{$key->sales->payment_remain}}</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')">
										@if($key->customer_shipment_status=="false")
										Error/Hapus @else Dikirim @endif</td>
									<td onclick="detail ({{$key->sales->id}},'penjualan')">{{$key->sales->createdBy}}
									</td>
									<td>
										<div id="menutable">
											<a href="<?php echo url("/") ?>/penjualan/{{$key->sales->id}}"
												class="btn btn-xs btn-warning dis" style="width: 100%">Edit</a><br>
											<button class="btn btn-xs btn-danger dis"
												onclick="konfirmasi({{$key->sales->id}},'penjualan')"
												style="width: 100%">Delete</button><br>
											<button onclick="printfaktur({{$key->sales->id}},'penjualan')"
												class="btn btn-xs btn-success " style="width: 100%">Print Faktur
											</button>
										</div>
									</td>
								</tr>
								@empty

								@endforelse

							</tbody>

						</table>
					</div>
				</div>
			</div>
		</section><!-- /.content -->
	</div>
</div>
@endsection

@push("js")

<script type="text/javascript">
	var totalsum =table.column( 6, {page: "all"} ).data().sum();
	val = totalsum;
	var res = "Rp. " + number_format(val, 2, ",", ".");
	$(".totalhutang").text(res);

</script>

@endpush
