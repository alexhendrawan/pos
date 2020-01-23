@extends("layouts.main")
@section("title")
Piutang
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class=" table-responsive">
			<div class="row">
				<form class="col-md-6" action="{{ url("piutang") }}">
					<input type="date" name="date_start" value="{{$data->date_start ?? "" }}">
					-
					<input type="date" name="date_end" value="{{ $data->date_end ?? "" }}">
					<input type="submit" name="" value="Submit!">
				</form>
				<form class="col-md-6" action="{{ url("piutang/search") }}" method="get">
					<label for="key">
						Search By
						<select name="key" class="form-control w-100" id="key">
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
			</div>
			<table id="tabel" class="table table-bordered table-hover box">
				<thead>
					<th class="col-head">
						No

					</th>

					<th class="col-head">
						No Faktur Sales

					</th>
					<th class="col-head">
						Tanggal Pembayaran

					</th>
					<th class="col-head">
						Customer

					</th>
					<th class="col-head">
						Status

					</th>
					<th class="col-head">
						Jumlah Pembayaran

					</th>

					<th class="col-head">
						Notes
					</th>

					<th class="col-head">
						Payment
					</th>
					<th>
						Action
					</th>

				</thead>
				<tbody id="item-table">
					@foreach($data->content as $key)<tr>
						<td class="">{{ $loop->iteration }}</td>
						<td><a class="btn btn-info"
								href="{{ url("penjualan")."/".$key->sales->id }}">{{$key->sales->intnomorsales ?? null}}</a>
						</td>
						<td>{{date("d-m-Y",strtotime($key->createdOn))}}</td>
						<td><a class="btn btn-info"
								href="{{ url("konsumen")."/".$key->sales->customer->id }}">{{$key->sales->customer->name ?? null}}</a>
						</td>
						<td>{{$key->sales_invoice_payment_status ?? null}}</td>
						<td>Rp. {{number_format($key->payment_value)}}</td>
						<td>{{$key->note ?? null}}</td>

						<td>@if($key->payment_id=="C")
							Cash
							@elseif($key->payment_id=="G")
							Giro
							@elseif($key->payment_id=="CH")
							Cek
							@elseif($key->payment_id=="TR")
							Transfer
							@endif
						</td>
						<td>
							<div id="menutable">
								<a href="<?php echo url("/") ?>/piutang/{{$key->id}}/edit"
									class="btn btn-xs btn-warning dis" style="width: 100%">Edit</a><br>
								<button class="btn btn-xs btn-danger dis" onclick="konfirmasi({{$key->id}},'piutang')"
									style="width:100%">Delete</button>
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