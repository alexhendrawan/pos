@extends("layouts.main")
@section("title")
Retur Pembelian
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class="py-4">

			<div class="col-md-12 col-xs-12">
				<form method="post" action="{{url('/')}}/retur-pembelian">
					{{csrf_field()}}
					<div class="row">
						<div class="form-group col-md-6">
							Supplier:
							<select name="supplier" class="form-control supplier"></select>
						</div>

						<div class="form-group col-md-6">
							Alamat:
							<p id="alamatsupplier"></p>
							Telepon:
							<p id="teleponsupplier"></p>
						</div>
					</div>
					<div class="row">
						<div class="form-group col-md-6">
							Nomor Penerimaan:
							<select name="nomor" class="form-control invbysupplier"></select>
						</div>

						<div class="form-group col-md-6">
							Total Invoice:
							<p id="totalinvoice"></p>
							Total Bayar:
							<p id="totalbayar"></p>
						</div>
					</div>

					<div class="hide form-group">
						Status:
						<select id="var2" name="supplier_return_header_status" class="form-control">
							<option value="DR">Draft</option>
							<option selected value="C">Confirm</option>

						</select>
					</div>
					<div id="databarang">
						<input autocomplete="off" type="hidden" name="count" class="count" value="">
					</div>

					<div class="row">
						<div class="form-group col-md-12">
							<h4> Total : <span class="gtotalreturtext printUang"></span></h4>
							<input autocomplete="off" type="hidden" disabled="" name="" class="gtotalretur">
						</div>
						<div class="form-group col-md-12">
							<input autocomplete="off" type="submit" class="form-control btn btn-info dis"
								value="Create">
						</div>
					</div>

				</form>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							Stok Barang:
							<select type="text" class="stocks form-control" required=""></select>
						</div>

						<div class="form-group">
							Harga Retur:
							<input type="number" autocomplete="off" id="hargaretur" class="form-control" required="" />
						</div>
						<div class="form-group">
							Qty:
							<input autocomplete="off" type="number" id="var4" value="" class="form-control" required="">
						</div>
					</div>
					<div class="col-md-6 box" id="bbb" style="height: auto; overflow-y: auto">
						<table id="" class="table table-bordered table-stripped">
							<thead>
								<th>No.</th>
								<th>Barang</th>
								<th>QTY</th>
								<th>Harga Satuan</th>
								<th>Void</th>
							</thead>
							<tbody id="myTable">
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<section class=" table-responsive">
				<div class="row">

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


			</section>
	</div>
</div>
@endsection
@push("js")

<script type="text/javascript">
	var maxStock = 0;

	$('.supplier').select2({
		selectOnClose: true,
		placeholder: 'Pilih Supplier',
		ajax: {
			url: "{!! url('/') !!}" + '/ajax/supplier',
			dataType: 'json',
			delay: 1000,
			processResults: function(data) {
				return {
					results: $.map(data, function(item) {
						return {
							text: item.supplier_name,
							id: item.id
						}
					})
				};
			},
			cache: true
		}
	});

	$(".supplier").change(function() {
		$.ajax({
			url: "{!! url('/') !!}" + '/ajax/supplier/' + $(".supplier").val(),
			method: "get",
			success: function(response) {
				$("#alamatsupplier").text(response.data.supplier_address);
				$("#teleponsupplier").text(response.data.phone_num);
			},
			error: function(xhr, statusCode, error) {}
		});

		$('.invbysupplier').select2({
			selectOnClose: true,
			placeholder: 'Pilih Nomor',
			ajax: {
				url: "{!! url('/') !!}" + '/ajax/purchase_invoice/' + $(".supplier").val() + "/supplier",
				dataType: 'json',
				delay: 1000,
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								text: item.internal_invoice_no,
								id: item.id
							}
						})
					};
				},
				cache: true
			}
		});

		$('.stocks').select2({
			selectOnClose: true,
			placeholder: 'Pilih Barang',
			ajax: {
				url: "{!! url('/') !!}" + '/ajax/itemstock',
				dataType: 'json',
				delay: 1000,
				processResults: function(data) {
					return {
						results: $.map(data.data, function(items) {
							return {
								text: items.inventoryproperty.item.item_name,
								id: items.id
							}
						})
					};
				},
				cache: true
			}
		});
	})


	// $('.stock').select2({
	// 	selectOnClose: true,
	// 	placeholder: 'Pilih stok',
	// 	ajax: {
	// 		url: "{!! url('/') !!}" + '/ajax/itemstock',
	// 		dataType: 'json',
	// 		delay: 1000,
	// 		processResults: function (data) {
	// 			return {
	// 				results: $.map(data.data, function (items) {
	// 					return {
	// 						text: items.inventoryproperty.item.item_name,
	// 						id: items.id
	// 					}
	// 				})
	// 			};
	// 		},
	// 		cache: true
	// 	}
	// });


	$('.invbysupplier').change(function() {
		$.ajax({
			url: "{!! url('/') !!}" + '/ajax/purchase_invoice/' + $('.invbysupplier').val(),
			method: "get",
			success: function(response) {
				$("#totalinvoice").text(addDecimal(response.invoice_total));
				$("#totalbayar").text(addDecimal(response.paid_total));
			},
			error: function(xhr, statusCode, error) {}
		});
	})


	flagrow = 0;

$(".stocks").change(function () {
	maxStock = 0;
    flagrow = 0;


    $.ajax({
        url: "{!! url('/') !!}" + '/ajax/po_line/' + $(".stocks").val() + '/inventoryproperty',
        method: "get",
        success: function (response) {
            $("#hargaretur").val(response.price_per_satuan_id);
    	console.dir(response);
        },
        error: function (xhr, statusCode, error) { }
    });

    	$.ajax({
			url: "{!! url('/') !!}" + "/ajax/itemstock/" + $(".stocks").val(),
			method: "get",
			success: function (response) {
				maxStock = response["qty"];
				if(response["qty"] <= 0){
					swal("Jumlah Stock 0. Harap melakukan pembelian terlebih dahulu");
				}
			},
			error: function (xhr, statusCode, error) {
			}
		});
});

var count = 1;
var total = 0;
$(window).keydown(function (event) {
    if (event.keyCode == 13) {
    	  if (maxStock <= 0 || maxStock < $("#var4").val()) {
                    swal("Barang Minus / Tidak Cukup, Harap diperbaiki terlebih dahulu");
                    
                }else{
        $.ajax({
            url: "{!! url('/') !!}" + "/ajax/itemstock/" + $(".stocks").val(),
            method: "get",
            success: function (data) {
              
					var harga = 0;

                    var table = document.getElementById("myTable");
                    var row = table.insertRow();
                    row.setAttribute('id', 'row' + count);

                    var cell0 = row.insertCell(0);
                    cell0.setAttribute('class', 'number');
                    var cell1 = row.insertCell(1);
                    var cell2 = row.insertCell(2);
                    var cell3 = row.insertCell(3);
                    var cell4 = row.insertCell(4);
                    var id = $(".stocks").val();

                    cell1.innerHTML = $(".stocks option:selected").text();
                    cell2.innerHTML = $("#var4").val();
                    cell3.innerHTML = $("#hargaretur").val();
                    cell4.innerHTML = '<button type="button" onclick="voidbarang(' + count + ')">Void</button>'
                    harga = $("#hargaretur").val();

                    var container = document.getElementById("databarang");

                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "data-item-id-" + count;
                    input.setAttribute('value', $(".stocks").val());
                    input.setAttribute('id', "data-item-id-" + count);
                    container.appendChild(input);

                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "data-qty-id-" + count;
                    input.setAttribute('value', $("#var4").val());
                    input.setAttribute('id', "data-qty-id-" + count);
                    container.appendChild(input);

                    var input = document.createElement("input");
                    input.type = "hidden";
                    input.name = "data-harga-id-" + count;
                    input.setAttribute('value', harga);
                    input.setAttribute('id', "data-harga-id-" + count);
                    container.appendChild(input);



                    $(".count").val(count);
                    count++;
                    var objDiv = document.getElementById("bbb");
                    objDiv.scrollTop = objDiv.scrollHeight;
                    updateRowOrder();
                    total += $("#var4").val() * harga;
                    $(".gtotalretur").val(total);

                    $(".gtotalreturtext").text(addDecimal(total));
                    updateRowOrder();
            },
            error: function (xhr, statusCode, error) {
            }
        });
				}
    }
});
</script>

<script type="text/javascript">
	function voidbarang(count) {
		var total = $(".gtotalretur").val();
		var harga = $("#data-harga-id-" + count).val();
		var qty = $("#data-qty-id-" + count).val();
		$("#data-unit-id-" + count).remove();
		$("#data-qtyget-id-" + count).remove();
		$("#data-qty-id-" + count).remove();
		$("#data-harga-id-" + count).remove();
		$("#data-warna-id-" + count).remove();
		$("#data-item-id-" + count).remove();
		$("#data-unit-id-" + count).remove();
		$("#row" + count).remove();
		count--;
		total -= parseInt(qty) * parseInt(harga);
		$(".count").val(count);
		$(".gtotalretur").val(total);
		$(".gtotalreturtext").text(addDecimal(total));

		updateRowOrder();
	}
</script>

<script type="text/javascript">
	$(".stocks").change(function() {
		$.ajax({
			url: '{!! url("/") !!}' + "/ajax/returnsupplierhistory/" + $(".stocks").val() + "/" + $(".supplier").val(),
			method: "get",
			success: function(response) {
				$('.mytablerow').remove();

				$.each(response, function(i, item) {

					var table = document.getElementById("history");
					var row = table.insertRow();
					row.setAttribute('id', 'row' + count);
					row.setAttribute('class', 'mytablerow');

					var cell1 = row.insertCell(0);
					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);
					console.dir(item);

					cell1.innerHTML = formatDate(item['createdOn']);
					cell2.innerHTML = item['item_name'];
					cell3.innerHTML = item['qty_get'];
					cell4.innerHTML = addDecimal(item['price_per_satuan_id']);
				});
			},
			error: function(xhr, statusCode, error) {}
		})
	});
</script>
@endpush