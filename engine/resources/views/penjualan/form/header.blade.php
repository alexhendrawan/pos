<div id="home1" class="tab-pane fade active show">

	@csrf
	<div class="row col-lg-12">
		<div class="col-lg-6">
			<div class="form-group hide">
				Status:
				<select name="status" class="form-control">
					<option value="DR">Draft</option>
					<option selected value="C">Confirm</option>

				</select>
			</div>
			<div class="form-group">
				Customer:
				<select name="customer_id" class="customer form-control" required="">
				</select>
			</div>

			<div class="col-lg-6">
				Alamat: <span id="alamatcust"></span>
			</div>

			<div class="col-lg-6">
				Sales: <span id="salescust"></span>

			</div>


			<div class="form-group hide">
				POS:
				<select name="pos">
					<option value="true">True</option>
					<option selected value="false">False</option>
				</select>
			</div>


			<div class="form-group ">
				Total:
				<input autocomplete="off" type="text" disabled="" value="0" class="gtotal" required="">
				<input autocomplete="off" type="hidden" value="0" maxlength="19" name="total_sales"
					class="form-control gtotal" required="">
			</div>
		</div>
		<div class="col-lg-6">

			<div class="form-group d-none">
				Status

				<select name="var3" class="form-control">
					<option selected value="1">Dikirim</option>
				</select>
			</div>


			<input autocomplete="off" type="hidden" name="var1" value="1" class="form-control">

			<div class="form-group">
				Supir:
				<select class="form-control driveremployee" name="staff1">
					<option></option>
					@foreach($supir as $key)
					<option value="{{ $key->id }}">{{ $key->displayName }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group">
				Kenek:
				<select class="form-control kenekemployee" name="staff2">
					<option></option>
					@foreach($kenek as $key)
					<option value="{{ $key->id }}">{{ $key->displayName }}</option>
					@endforeach
				</select>

			</div>
			<div class="form-group ">
				Jatuh Tempo:
				<input autocomplete="off" type="date" name="due_date" class="form-control"
					value="{{date('Y-m-d',strtotime('+30 days'))}}" id="jatuh_tempo">

			</div>

			<div class="form-group">
				Tanggal Kirim
				<input autocomplete="off" type="date" value="{{date('Y-m-d')}}" name="order_date"
					class="form-control" id="tgl_kirim" onchange="changedate()">
			</div>

		</div>
	</div>

	<div class="form-group ">

		<input autocomplete="off" type="hidden" value="0" maxlength="10" name="gt" class="form-control" required="">
	</div>

	<div id="databarang">
		<input autocomplete="off" type="hidden" name="count" class="count" value="">
	</div>

</div>

@push("js")
<script>
	function changedate(){
		jatuhtempo = new Date($("#tgl_kirim").val());
		jatuhtempo.setDate(jatuhtempo.getDate()+29);

	var day = ("0" + jatuhtempo.getDate()).slice(-2);
	var month = ("0" + (jatuhtempo.getMonth() + 1)).slice(-2);
	var today = jatuhtempo.getFullYear()+"-"+(month)+"-"+(day) ;
$("#jatuhtempo").val(today);

	}
	</script>
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