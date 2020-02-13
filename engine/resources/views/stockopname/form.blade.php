@extends("layouts.main")
@section("title")
Stock Opname
@endsection
@section("content")
<div class=" container-fluid   container-fixed-lg">

	<div class="row">
		<div class="col-md-12">
			<br>
			<form action="{{url('/')}}/stock_opname" method="post">
				@csrf

				<div id="databarang">
					<input autocomplete="off" type="hidden" name="count" class="count" value="">
				</div>
				<div class="row">

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
							QTY Opname:
							<input autocomplete="off" type="number" id="var5" class="form-control">
							<input autocomplete="off" type="hidden" id="var18" class="form-control">
						</div>
						<div class="form-group hide">
							<input autocomplete="off" type="button" onclick="myFunction()"
								class="form-control btn btn-info dis" value="Tambah Barang">
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
									<th>Void</th>

								</thead>
								<tbody id="myTable">

								</tbody>
							</table>
						</div>
					</div>

					<input autocomplete="off" type="submit" class="form-control btn btn-success" value="Create"
						style="width:100%;">
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push("js")

<script>
	$(window).keydown(function (event) {
			if (event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});

</script>
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

</script>
<script type="text/javascript">
	var count = 1;
	var realcount = 0;
	$(window).keydown(function (event) {
		if (event.keyCode == 13) {

			if ($("#var5").val() >= 0) {
				var table = document.getElementById("myTable");
				var row = table.insertRow();
				row.setAttribute('id', 'row' + count);
				var cell0 = row.insertCell(0);
				var cell1 = row.insertCell(1);
				var cell2 = row.insertCell(2);
				var cell3 = row.insertCell(3);
				cell0.setAttribute('class', "number");
				if ($("#var10").val() == 0) {
					cell1.innerHTML = $(".stock option:selected").text() + " (Bonus)";
				} else {
					cell1.innerHTML = $(".stock option:selected").text();
				}
				cell2.innerHTML = "<input type='hidden' name='data-item-id-"+ count+"' value='"+$(".stock").val()+"'><input type='number' name='data-qty-id-"+ count+"' value='"+$("#var5").val()+"'>";
				cell3.innerHTML = '<button type="button" onclick="voidbarang(' + count + ')">Void</button>';
				

				$(".count").val(count);
				count++;
				realcount++;
				$("#var3").val(null).trigger('change');
				$("#var5").val(null);
				updateRowOrder();
				$(".dis").show();
				
			} else {
				swal("kuantitas harus di isi");
			}
			$(".stock").select2("open");
		}
	});
</script>
<script type="text/javascript">
	function voidbarang(count) {
		$("#data-unit-id-" + count).remove();
		$("#data-qtyget-id-" + count).remove();
		$("#data-qty-id-" + count).remove();
		$("#data-item-id-" + count).remove();
		$("#data-unit-id-" + count).remove();
		$("#data-diskon-id-" + count).remove();
		$("#data-harga-" + count).remove();

		$("#data-sub-id-" + count).remove();
		$("#row" + count).remove();
		calculatetotalsales();
		realcount--;
		updateRowOrder();

	
		if($('#myTable tr').length > 0){
			$(".dis").show();
		}else{
			$(".dis").hide();
		}
	}

	
</script>
@endpush