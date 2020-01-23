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
						<input autocomplete="off" type="text" maxlength="15" id="var1" name="supplier_invoice_no"
							class="form-control" required="">
					</div>

					<input autocomplete="off" type="hidden" maxlength="15" id="var1" name="internal_invoice_no"
						class="form-control" value="{{$data->po_no}}">

					<input autocomplete="off" type="hidden" maxlength="15" id="var1" name="suratjalan"
						class="form-control" value="0">

					<div class="form-group hide">
						Status:
						<select id="var2" name="purchase_invoice_status" class="form-control">
							<option value="DR">Draft</option>
							<option selected value="C">Confirm</option>

						</select>
					</div>

					<div class="form-group">
						Tanggal Faktur:
						<input autocomplete="off" type="date" id="var5" name="invoice_date" class="form-control"
							required="" value="{{date('Y-m-d')}}">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						Nilai Faktur:
						<input autocomplete="off" type="text" id="nilaifak" maxlength="10" name="invoice_total"
							value="0" class="form-control nilaifak" required="">
					</div>
					<div class="form-group">

						<input autocomplete="off" type="hidden" value="0" id="var5" maxlength="10" name="paid_total"
							class="form-control" required="">
					</div>
					<div id="databarang">
						<input autocomplete="off" type="hidden" name="count" class="count"
							value="{{count($data->line)}}">
					</div>
					<div class="form-group">
						<input autocomplete="off" type="submit" onsubmit="check();"
							class="form-control btn btn-info dis" value="Create">
					</div>
				</div>
			</div>

			<div class="col-md-12 box">
				<div class="form-group">
					<input autocomplete="off" type="hidden" name="po_header_id" value="{{$data->id}}" id="var2"
						class="form-control" required="">

				</div>

				<br><br><br>

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
							@foreach($data->line as $key)
							<tr>
								<td>{{$loop->iteration}}</td>
								<td>{{$key->inventoryproperty->item->item_name}}</td>
								<td>{{$key->qty_buy}} {{$key->satuan->name}}</td>
								<td><input type="text" onkeyup="calculatetotal()" name="qty-get-{{$loop->iteration}}"
										id="qty-get-{{$loop->iteration}}" value="{{$key->qty_buy}}" style="width:50%">
									{{$key->satuan->name}}</td>
								<td><input type="text" value="{{$key->stock->purchase_price?? 0}}"
										onkeyup="calculatetotal()" name="pp-get-{{$loop->iteration}}"
										id="pp-get-{{$loop->iteration}}"></td>
								<td><input type="text" value="{{$key->stock->sell_price?? 0}}"
										onkeyup="calculatetotal()" name="sp-get-{{$loop->iteration}}"
										id="sp-get-{{$loop->iteration}}"></td>
								<td>
									<select class="warehouse form-control" style="width:100%"
										name="gudang-get-{{$loop->iteration}}" id="gudang-get-{{$loop->iteration}}">
										<option value="{{$data->warehouse->id}}" selected>
											{{$data->warehouse->warehouse_name}}</option>
									</select>
								</td>

							</tr>
							<input type="hidden" name="data-line-id-{{$loop->iteration}}"
								id="data-line-id-{{$loop->iteration}}" value="{{$key->id}}">
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
            delay: 1000,
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
