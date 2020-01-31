@push("css")
<style type="text/css">
	.modal-dialog {
		width: auto !important;
		max-width: 1000px;
	}
</style>
@endpush
<div id="profile1" class="tab-pane fade">
	<div class="row">

		<div class="form-group col-lg-6">
			Total:
			<input autocomplete="off" type="text" disabled="" value="0" class="gtotal" required="">
			<input autocomplete="off" type="hidden" value="0" maxlength="19" name="total_sales"
				class="form-control gtotal" required="">
		</div>
		<div class="form-group col-lg-6 d-flex">
			<h4>Hutang: </h4>
			<h4 id="hutang"></h4>
			<!-- Button to Open the Modal -->
			<button type="button" id="btn-riwayat" class="btn btn-sm btn-primary ml-4" data-toggle="modal"
				data-target="#myModal">Riwayat</button>
		</div>

	</div>
	<div class="row col-lg-12">
		<hr>
		<div class="col-lg-4">
			<div class="form-group">
				Barang:
				<select id="var3" class="stock form-control" style="width: 100%">
				</select>
			</div>
			<div class="form-group">
				Harga Satuan: <a onclick="$('.modalhide').toggle()">&nbsp;&nbsp;&nbsp;&nbsp;</a>
				<input autocomplete="off" type="number" id="var10" class="form-control">
				<span class="modalhide">Harga Modal</span>
				<input autocomplete="off" type="number" disabled id="var20" class="form-control modalhide">
			</div>
			<div class="form-group">
				Diskon (%):
				<input autocomplete="off" type="text" id="var11" class="form-control">
			</div>
			<div class="form-group">
				QTY Buy:
				<input autocomplete="off" type="number" id="var5" class="form-control">
				<input autocomplete="off" type="hidden" id="var18" class="form-control">
			</div>
			<div class="form-group hide">
				<input autocomplete="off" type="button" onclick="myFunction()" class="form-control btn btn-info dis"
					value="Tambah Barang">
			</div>
			<input autocomplete="off" type="hidden" id="pur">
			<input autocomplete="off" type="hidden" id="gtx">

		</div>
		<div class="col-lg-8" style="overflow-y: auto; max-height: 500px">
			<div>
				<table id="" class="table table-bordered table-stripped">
					<thead>
						<th>No</th>
						<th>Kode Barang</th>
						<th>QTY</th>
						<th>Harga Satuan</th>
						<th>Subtotal</th>
						<th>Void</th>

					</thead>
					<tbody id="myTable">

					</tbody>
				</table>
			</div>
		</div>
		<section class=" table-responsive">
			<div class="row">
				<div class="box col-md-12">
					<div class="col-md-12 col-xs-12">
						<div class="col-md-12" id="ccc">
							<table id="" class="table table-bordered table-stripped">
								<thead>
									<th>Tanggal</th>
									<th>Barang</th>
									<th>QTY</th>
									<th>Harga Satuan</th>
								</thead>
								<tbody id="history">
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>


		</section>
		<input type="checkbox" name="prints"> Langsung Print?

		<input autocomplete="off" type="submit" id="cekcek" class="form-control btn btn-success" value="Create"
			style="width:100%;">
	</div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">

			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Riwayat Hutang</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

			<!-- Modal body -->
			<div class="modal-body">
				<table class="table table-bordered table-hover box">
					<thead class="replicate">
						<th class="col-head">
							No

						</th>
						<th class="col-head">
							No Sales
						</th>

						<th class="col-head">
							Tanggal Order
						</th>
						<th class="col-head">
							Total Faktur <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
								title="Sudah dikurangi Retur dan Diskon"></i>
						</th>
						<th class="col-head">
							Total Bayar <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
								title="Total Yang sudah dibayarkan"></i>
						</th>
						<th class="col-head">
							Retur
						</th>
						<th class="col-head">
							Sisa Bayar <i class="fa fa-question-circle" data-toggle="tooltip" data-placement="top"
								title="Sudah dikurangi Retur dan Diskon"></i>
						</th>
					</thead>

					<tbody id="item-table">

					</tbody>
				</table>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>

		</div>
	</div>
</div>

@push("js")
<script>
	$('.stock').select2({
		selectOnClose: true,
		placeholder: 'Pilih stok',
		ajax: {
			url: "{!! url('/') !!}" + '/ajax/itemstock',
			dataType: 'json',
			delay: 1000,
			processResults: function (data) {
				return {
					results: $.map(data.data, function (items) {
						return {
							text: items.inventoryproperty.item.item_name,
							id: items.id
						}
					})
				};
			},
			// cache: true
		}
	});

	$(".stock").change(function () {
		flagrow = 0;
		$("#cekcek").show();

		// $(".stock").select2('data', null)
		// $('.stock').html('').select2({data: [{id: '', text: ''}]});
		$.ajax({
			url: "{!! url('/') !!}" + "/ajax/itemstock/" + $(".stock").val(),
			method: "get",
			success: function (response) {
				$("#var10").val(response["sell_price"]);
				$("#var20").val(response["purchase_price"]);
				$("#sell_price").val(response["sell_price"]);
				$("#buyprice").val(response["purchase_price"]);
				if(response["qty"] <= 0){
					swal("Jumlah Stock 0. Harap melakukan pembelian terlebih dahulu");
					$("#cekcek").hide();
					flagrow = count;
				}else{
				}
			},
			error: function (xhr, statusCode, error) {
			}
		});
	});

	$(".customer").change(function(){
		$("#item-table").empty();
		$.ajax({
			url: "{!! url('/') !!}" + "/ajax/customer/" + $(".customer").val() +"/riwayat/id",
			method: "get",
			success: function (response) {
				console.dir(response);
				$.each(response["data"], function (i, item) {
					var table = document.getElementById("item-table");
					var row = table.insertRow();
					row.setAttribute('id', "");
					var cell1 = row.insertCell(0);
					cell1.setAttribute('class', 'number');

					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					var cell5 = row.insertCell(4);
					var cell6 = row.insertCell(5);
					var cell7 = row.insertCell(6);

					cell2.innerHTML = item['intnomorsales'];
					cell3.innerHTML = formatDate(item['createdOn']);
					cell4.innerHTML = addDecimal(item['total_sales']);
					cell5.innerHTML = addDecimal(item['total_paid']);
					cell6.innerHTML = addDecimal(item['retur']);
					cell7.innerHTML = addDecimal(item['payment_remain']);

					updateRowOrder();
				});

			},
			error: function (xhr, statusCode, error) {
			}
		});
	});
</script>
@endpush