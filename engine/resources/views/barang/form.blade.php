@extends("layouts.main")
@section("title")
	Barang
@endsection
@section("content")
	<div class="page-content-wrapper">
		<div class="container-fluid">
			<section class="table-responsive">
				<form method="post" action="{{url('/')}}/barang">
					@csrf

					<div class="form-group">
						Nama Item:
						<input autocomplete="off" type="text" id="var1" class="form-control" name="item_name">

					</div>

					<div class="form-group">
						Nama Merk:
						<select class="brands form-control" name="brand_id"></select>
					</div>

					<div class="form-group">
						Nama Kategori:
						<select class="category form-control" name="item_color_id"></select>
					</div>

					<div class="form-group">
						Batas Bawah:
						<input autocomplete="off" type="text" id="var1" class="form-control" name="threshold_bottom"
							   required="" value="0">
					</div>

					<div class="form-group">
						Batas Atas:
						<input autocomplete="off" type="text" id="var1" class="form-control" name="threshold_top"
							   required="" value="0">
					</div>

					<div class="form-group">
						<input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Create">
					</div>
				</form>
			</section><!-- /.content -->
		</div>
	</div>
@endsection

@push("js")
	<script>
		$('.brands').select2({
			selectOnClose: true,
			placeholder: 'Pilih merk',
			ajax: {
				url: "{!! url('/') !!}" + '/ajax/brand',
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

		$('.category').select2({
			selectOnClose: true,
			placeholder: 'Pilih Kategori',
			ajax: {
				url: "{!! url('/') !!}" + '/ajax/category',
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
	</script>
@endpush

