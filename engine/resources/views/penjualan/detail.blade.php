@extends("layouts.main")
@section("title")
Penjualan Detail
<h5>{{ ($data->sales->intnomorsales ?? "-") ." ". ($data->sales->customer->name ?? "-")}} <a
		href="{{ url("penjualan-detail/".$data->sales->id."/create") }}" class="btn btn-info">Tambah Data</a></h5>
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class=" table-responsive">
			<form action="{{url('/')}}/penjualan/{{$data->sales->id}}" method="post">
				@csrf
				@method("put")
				<div class="row col-md-12">
					<div class="col-md-6">
						<div class="form-group ">
							Customer:
							<select name="customer_id" class="customer form-control" required="">
								<option value="{{$data->sales->customer->id}}">{{$data->sales->customer->name}}</option>
							</select>

						</div>
						<div class="form-group ">
							Tanggal Order:
							<input autocomplete="off" type="date" name="order_date"
								value="{{date("Y-m-d",strtotime($data->sales->createdOn))}}">

						</div>
						<div class="form-group ">
							Jatuh Tempo:
							<input autocomplete="off" type="date" name="due_date"
								value="{{date("Y-m-d",strtotime($data->sales->due_date))}}">

						</div>
						<div class="form-group">
							Supir:
							<select class="form-control driveremployee" name="sales1_id">
								<option selected="" value="{{$data->supir->id ?? null}}">
									{{$data->supir->displayName ?? null}}</option>
								@foreach($supir as $key)
								<option value="{{ $key->id }}">{{ $key->displayName }}</option>
								@endforeach
							</select>
							</select>
						</div>

						<div class="form-group">
							Kenek:
							<select class="form-control kenekemployee" name="sales2_id">
								<option selected="" value="{{$data->kenek->id ?? null}}">
									{{$data->kenek->displayName  ?? null}}</option>
								@foreach($kenek as $key)
								<option value="{{ $key->id }}">{{ $key->displayName }}</option>
								@endforeach

							</select>

						</div>
					</div>
					<div class="col-md-6">
						<h3>Total Penjualan: Rp. {{ number_format($data->sales->total_sales) }}</h3>
						<h3>Total Bayar: Rp. {{ number_format($data->sales->total_paid)}}</h3>
						<h3>Total Retur: Rp. {{ number_format($data->sales->retur)}}</h3>
					</div>
				</div>


				<div class="form-group">
					<input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Ubah Data!">
				</div>
			</form>
			<h2>Barang</h2>
			<table id="tabel" class="table table-bordered table-hover box">
				<thead>
					<th class="col-head">
						No
					</th>
					<th class="col-head">
						Item
					</th>
					<th class="col-head">
						Satuan
					</th>
					<th class="col-head">
						Qty
					</th>
					<th class="col-head">
						Harga
					</th>
					<th class="col-head">
						Total Harga
					</th>
					<th>
						Action
					</th>
				</thead>
				<tbody id="item-table">
					@foreach($data->sales->detail as $key)
					<tr>
						<td class="">{{$loop->iteration}}</td>
						<td>{{$key->stock->inventoryproperty->item->item_name}}</td>

						<td>{{$key->stock->satuan->name ?? null}}</td>
						<td class="">{{$key->qty}}</td>
						<td class="printUang">{{$key->price_per_satuan_id}}</td>
						<td class="printUang">{{$key->qty * $key->price_per_satuan_id}}</td>
						<td>
							<div id="menutable">
								<a href="<?php echo url("/") ?>/penjualan-detail/{{$key->id}}/edit"
									class="btn btn-xs btn-warning dis" style="width: 100%">Edit</a><br>
								<button class="btn btn-xs btn-danger dis"
									onclick="konfirmasi({{$key->id}},'penjualan-detail')"
									style="width: 100%">Delete</button><br>
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


@push("js")
<script>
	$('.customer').select2({
        selectOnClose: true,
        placeholder: 'Pilih Konsumen',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/customer',
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
    $(".driveremployee").select2({
        placeholder: "Pilih Supir"
    });
    $(".kenekemployee").select2({
        placeholder: "Pilih Kenek"
    });

    $(".customer").change(function(){

        $.ajax({
            url: "{!! url('/') !!}"+ "/ajax/customer/" + $(".customer").val(),
            method: "get",
            success: function (response) {
                $("#alamatcust").text(response['customer_address']);
                $("#phonecust").text(response['customer_phone_no']);
                $("#salescust").text(response['sales']['displayName']);
            },
            error: function (xhr, statusCode, error) {
            }
        });

        $.ajax({
            url: "{!! url('/') !!}"+ "/ajax/customer/" + $(".customer").val() +'/hutang',
            method: "get",
            success: function (response) {
                $("#hutang").text(addDecimal(response['hutang']));
            },
            error: function (xhr, statusCode, error) {
            }
        });
    });
</script>
@endpush
