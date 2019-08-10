@extends("layouts.main")
@section("title")
Penjualan
@endsection
@section("content")
<div class=" container-fluid   container-fixed-lg">

	<div class="row">
		<div class="col-md-12">
			<ul id="tabsJustified" class="nav nav-tabs">
				<li class="nav-item"><a href="" data-target="#home1" data-toggle="tab" class="nav-link small text-uppercase active">Data Customer</a></li>
				<li class="nav-item"><a href="" data-target="#profile1" data-toggle="tab" class="nav-link small text-uppercase " id="showmodal">Barang</a></li>
			</ul>
			<br>
			<form action="{{url('/')}}/penjualan" method="post">
				@csrf
				<div id="tabsJustifiedContent" class="tab-content">
					@include("penjualan.form.header")
					@include("penjualan.form.line")
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push("js")
<script>
	$(document).ready(function () {
		$(window).keydown(function (event) {
			if (event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});
	});

</script>
<script type="text/javascript">
	var count = 1;
	var realcount = 0;
	$(window).keydown(function (event) {
		if (event.keyCode == 13) {

			if (realcount < 16 && $("#var5").val() != 0) {
				var table = document.getElementById("myTable");
				var row = table.insertRow();
				row.setAttribute('id', 'row' + count);
				var cell0 = row.insertCell(0);
				var cell1 = row.insertCell(1);
				var cell2 = row.insertCell(2);
				var cell3 = row.insertCell(3);
				var cell4 = row.insertCell(4);
				var cell5 = row.insertCell(5);
				cell0.setAttribute('class', "form_id");
				if ($("#var10").val() == 0) {
					cell1.innerHTML = $(".stock option:selected").text() + " (Bonus)";
				} else {
					cell1.innerHTML = $(".stock option:selected").text();
				}
				cell2.innerHTML = $("#var5").val() + " " + $("#var18").val();
				cell3.innerHTML = addDecimal((($("#var10").val() * $("#var5").val()) - (($("#var10").val() * $("#var11").val() / 100) * $("#var5").val())) / $("#var5").val());
				cell4.innerHTML = addDecimal(($("#var10").val() * $("#var5").val()) - (($("#var10").val() * $("#var11").val() / 100) * $("#var5").val()));
				cell5.innerHTML = '<button type="button" onclick="voidbarang(' + count + ')">Void</button>';
				var container = document.getElementById("databarang");
				var input = document.createElement("input");
				input.type = "hidden";
				input.name = "data-item-id-" + count;
				input.setAttribute('value', $(".stock").val());
				input.setAttribute('id', "data-item-id-" + count);
				container.appendChild(input);
				var input = document.createElement("input");
				input.type = "hidden";
				input.name = "data-sub-id-" + count;
				input.setAttribute('value', $("#var10").val() * $("#var5").val());
				input.setAttribute('id', "data-sub-id-" + count);
				container.appendChild(input);

				var input = document.createElement("input");
				input.type = "hidden";
				input.name = "data-qty-id-" + count;
				input.setAttribute('value', $("#var5").val());
				input.setAttribute('id', "data-qty-id-" + count);
				container.appendChild(input);

				var input = document.createElement("input");
				input.type = "hidden";
				input.name = "data-mod-id-" + count;
				input.setAttribute('value', $("#var20").val());
				input.setAttribute('id', "data-mod-id-" + count);
				container.appendChild(input);

				var input = document.createElement("input");
				input.type = "hidden";
				input.name = "data-diskon-id-" + count;
				input.setAttribute('value', $("#var11").val());
				input.setAttribute('id', "data-diskon-id-" + count);
				container.appendChild(input);

				var input = document.createElement("input");
				input.type = "hidden";
				input.name = "data-harga-" + count;
				input.setAttribute('value', (($("#var10").val() * $("#var5").val()) - (($("#var10").val() * $("#var11").val() / 100) * $("#var5").val())) / $("#var5").val());
				input.setAttribute('id', "data-harga-" + count);
				container.appendChild(input);
				$(".count").val(count);
				calculatetotalsales();
				count++;
				realcount++;
				$("#var3").val(null).trigger('change');
				$("#var5").val(null);
				$("#var10").val(null);
				$("#var11").val(null);
				$("#var20").val(null);
				updateRowOrder();
				$(".dis").show();
				$.ajax({
					url: "{{getenv('BASEURL_API')}}" + "sales_order_header/remain/" + $(".customer").val() + "/" + $(".gtotal").val(),
					method: "get",
					success: function (response) {
						if (response["message"] == "Tolak") {
							alert("Customer Sudah Melebihi Batas Hutang");
							$(".dis").attr("disabled", true);
						}
					},
					error: function (xhr, statusCode, error) {

					}
				})
			} else {
				swal("kuantitas harus di isi");
			}
			$(".stock").select2("open");
		}
	});
</script>
<script type="text/javascript">
	$(".stock").change(function () {
		$.ajax({
			url: "{!! url("/") !!}"+ "/ajax/salescustomerhistory/" + $(".stock").val() + "/" + $(".customer").val(),
			method: "get",
			success: function (response) {
				$('.mytablerow').remove();
				$.each(response, function (i, item) {
					var table = document.getElementById("history");
					var row = table.insertRow();
					row.setAttribute('id', 'row' + count);
					row.setAttribute('class', 'mytablerow');

					var cell1 = row.insertCell(0);
					var cell2 = row.insertCell(1);
					var cell3 = row.insertCell(2);
					var cell4 = row.insertCell(3);

					cell1.innerHTML = formatDate(item['createdOn']);
					cell2.innerHTML = item['stock']['inventoryproperty']['item']['item_name'];
					cell3.innerHTML = item['qty'];
					cell4.innerHTML = item['price_per_satuan_id'];
				});
			},
			error: function (xhr, statusCode, error) {
			}
		})
	});

</script>
<script type="text/javascript">
	function calculatetotalsales(count) {
		$(".gtotal").val(0);
		$(".gtotal").val(0);
		for (var i = 1; i <= $(".count").val(); i++) {
			if ($("#data-item-id-" + i).length > 0) {
				var harga = $("#data-harga-" + i).val();
				var qty = $("#data-qty-id-" + i).val();
				var hargakirim = $(".gtotal").val();
				var hargatampil = $(".gtotal").val();

				$(".gtotal").val(parseInt(hargakirim) + (parseInt(qty) * (parseInt(harga))));
				$(".gtotal").val(parseInt(hargakirim) + (parseInt(qty) * (parseInt(harga))));
			} else {

			}
		}

	}

</script>
<script type="text/javascript">
	function voidbarang(count) {
		$("#data-unit-id-" + count).remove();
		$("#data-qtyget-id-" + count).remove();
		$("#data-qty-id-" + count).remove();
		$("#data-warna-id-" + count).remove();
		$("#data-harga-id-" + count).remove();
		$("#data-sub-id-" + count).remove();
		$("#data-item-id-" + count).remove();
		$("#data-unit-id-" + count).remove();
		$("#data-diskon-id-" + count).remove();
		$("#data-harga-" + count).remove();

		$("#data-sub-id-" + count).remove();
		$("#row" + count).remove();
		calculatetotalsales();
		realcount--;
		updateRowOrder();

		$.ajax({
			url: "{{getenv('BASEURL_API')}}" + "sales_order_header/remain/" + $(".customer").val() + "/" + $(".gtotal").val(),
			method: "get",
			success: function (response) {
				if (response["message"] == "Tolak") {
					alert("Customer Masih Melebihi Batas Hutang");
					$(".dis").attr("disabled", true);
				} else {
					$(".dis").attr("disabled", false);

				}
			},
			error: function (xhr, statusCode, error) {

			}
		})
		if($('#myTable tr').length > 0){
			$(".dis").show();
		}else{
			$(".dis").hide();
		}
	}

	$("#showmodal").click(function () {
		$(".modalhide").toggle();
	})

	// $(".customer").change(function(){
	// 	$.ajax({
	// 		url: "{{getenv('BASEURL_API')}}" + "sales_order_header/remain/" + $(".customer").val() + "/total",
	// 		method: "get",
	// 		success: function (response) {
	// 			$("#hutang").val(addDecimal(response["data"]));
	// 		},
	// 		error: function (xhr, statusCode, error) {

	// 		}
	// 	})

	// })
</script>
@endpush
