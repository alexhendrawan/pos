@extends("layouts.main")
@section("title")
Retur Penjualan
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<form method="post" action="{{url('/')}}/retur-penjualan">
			{{csrf_field()}}
			<div class="row">
				<div class="form-group col-md-6">
					Pilih Konsumen
					<select class="customer form-control" name="customer_code" required=""></select>
				</div>
				<div class="form-group col-md-6">
					<p>Alamat: <span id="alamatcust"></span></p>
					<p>Telepon: <span id="phonecust"></span></p>
					<p>Sales: <span id="salescust"></span></p>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-md-6">
					Pilih Transaksi
					<select class="salesbycust form-control" name="nomor" required=""></select>
				</div>
				<div class="form-group col-md-6">
					<p>Total Sales: <span id="totalsales"></span></p>
					<p>Sisa Bayar: <span id="sisabayar"></span></p>
				</div>
			</div>
			<div class="hide form-group">
				Status:
				<select id="var2" name="status" class="form-control">
					<option value="DR">Draft</option>
					<option selected value="C">Confirm</option>

				</select>
			</div>
			<div id="databarang">
				<input autocomplete="off" type="hidden" name="count" class="count" value="">
			</div>

			<div class="form-group col-md-12">
				<h4> Total : <span class="gtotalreturtext printUang"></span></h4>
				<input autocomplete="off" type="hidden" value="0" name="" class="gtotalretur">
			</div>


			<div class="row">
				<div class="col-md-6 box">

					<div class="form-group">
						Barang
						{{-- <select class="stock form-control" name="sl" required=""></select> --}}
						<select class="stock form-control" name="sl" required=""></select>
					</div>
					<div class="form-group">
						Harga Retur:
						<input type="text" id="var10" class="form-control" required="" />
					</div>
					<div class="form-group">
						Qty:
						<input autocomplete="off" type="text" id="var4" value="" class="form-control" required="">
					</div>



				</div>

				<div class="col-md-6" id="bbb" style="height: auto; overflow-y: auto">
					<table id="" class="table table-bordered table-stripped">
						<thead>

							<th>No</th>
							<th>Barang</th>
							<th>QTY</th>
							<th>Harga</th>
							<th>Void</th>

						</thead>
						<tbody id="myTable">

						</tbody>
					</table>
					<div class="row">
						<div class="form-group col-md-7">
							<input autocomplete="off" type="submit" class="form-control btn btn-info dis"
								value="Create">
						</div>
						<div class="form-group col-md-5">
							<input type="checkbox" name="print"> Print?
						</div>
					</div>
		</form>
	</div>

</div>

</section><!-- /.content -->
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
</div>
</div>
@endsection
@push("js")

<script type="text/javascript">
	$(".stock").change(function () {
		$.ajax({
			url: "{!! url("/") !!}"+ "/ajax/returncustomerhistory/" + $(".stock").val() + "/" + $(".customer").val(),
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
					cell4.innerHTML = item['returprice'];
				});
			},
			error: function (xhr, statusCode, error) {
			}
		})
	});

</script>
<script>
	$('.customer').select2({
   selectOnClose: true,
   placeholder: 'Pilih Konsumen',
   ajax: {
    url: "{!! url('/') !!}" + '/ajax/customer',
    dataType: 'json',
    delay: 600,
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

   var id = $(".customer").val();

   $('.salesbycust').select2({
    selectOnClose: true,

    placeholder: 'Pilih Penjualan',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/sales/'+id+'/customer',
      dataType: 'json',
      delay: 600,
      processResults: function (data) {

        return {
          results: $.map(data, function (item) {

            return {
              text: item.intnomorsales,
              id: item.id

            }

          })

        };
      },
      cache: true

    }

  });
 });

  $(".salesbycust").change(function(){
    $("#sisabayar").text("");
    $("#totalsales").text("");
    $.ajax({
     url: "{!! url('/') !!}" + "/ajax/sales/" + $(".salesbycust").val(),
     method: "get",
     success: function (response) {
      $("#sisabayar").text(addDecimal(response.payment_remain));
      $("#totalsales").text(addDecimal(response.total_sales));
    },
    error: function (xhr, statusCode, error) {
    }
  });
  })


  $('.stock').select2({
    selectOnClose: true,
    placeholder: 'Pilih stok',
    ajax: {
     url: "{!! url('/') !!}" + '/ajax/itemstock',
     dataType: 'json',
     delay: 600,
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
   cache: true
 }
});

  $(".stock").change(function () {
    $.ajax({
     url: "{!! url('/') !!}" + "/ajax/itemstock/" + $(".stock").val(),
     method: "get",
     success: function (response) {
      $("#var10").val(response["sell_price"]);
      $("#var20").val(response["purchase_price"]);
      $("#sell_price").val(response["sell_price"]);
      $("#buyprice").val(response["purchase_price"]);

    },
    error: function (xhr, statusCode, error) {
    }
  });
  });


</script>

<script type="text/javascript">
	var count = 1;

  $(window).keydown(function (event) {

    if (event.keyCode == 13) {
      var hargaretur = 0
      var total = parseInt($(".gtotalretur").val());
      alert(total);
      var table = document.getElementById("myTable");
      var row = table.insertRow();
      row.setAttribute('id', 'row' + count);

      var cell0 = row.insertCell(0);
      cell0.setAttribute("class","form_id");
      var cell1 = row.insertCell(1);
      var cell2 = row.insertCell(2);
      var cell3 = row.insertCell(3);
      var cell4 = row.insertCell(4);
      hargaretur = $("#var10").val();
      cell1.innerHTML = $(".stock option:selected").text();
      cell2.innerHTML = $("#var4").val();
      cell3.innerHTML = addDecimal($("#var10").val());
      cell4.innerHTML = '<button type="button" onclick="voidbarang(' + count + ')">Void</button>'
      harga = $("#var10").val();

      var container = document.getElementById("databarang");

      var input = document.createElement("input");
      input.type = "hidden";
      input.name = "data-item-id-" + count;
      input.setAttribute('value', $(".stock").val());
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
      total += parseInt($("#var4").val()) * parseInt(harga);
      $(".gtotalretur").val(total);
      $(".gtotalreturtext").text("");
      $(".gtotalreturtext").text(addDecimal(total));
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
@endpush
