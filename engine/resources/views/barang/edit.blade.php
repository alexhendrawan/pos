@extends("layouts.main")
@section("title")
	Barang - {{$data->item->item_name}}
@endsection
@section("content")
	<div class="page-content-wrapper">
		<div class="container-fluid">
			<h1>Edit Barang</h1>
			<section class=" table-responsive">
				<form method="post" action="{{url('/')}}/barang/{{$data->id}}">
					@csrf
					@method('PUT')
					<div class="form-group">
						Kode Item:
						<input autocomplete="off" type="text" id="var1" class="form-control" name="item_code"
							   value="{{$data->item->item_code}}" required="">
					</div>

					<div class="form-group">
						Nama Item:
						<input autocomplete="off" type="text" id="var1" class="form-control" name="item_name"
							   value="{{$data->item->item_name}}" required="">
					</div>
					<div class="form-group">
						Nama Merk:
						<select class="brands form-control" name="brand_id">
							<option value="{{$data->brand->id}}" selected>{{$data->brand->name}}</option>
						</select>
					</div>

					<div class="form-group">
						Nama Kategori:
						<select class="category form-control" name="category_id">
							<option value="{{$data->category->id}}" selected>{{$data->category->name}}</option>
						</select>
					</div>

					<div class="form-group">
						Batas Bawah:
						<input autocomplete="off" type="text" id="var1" class="form-control" name="threshold_bottom"
							   required="" value="{{$data->threshold_bottom}}">
					</div>

					<div class="form-group">
						Batas Atas:
						<input autocomplete="off" type="text" id="var1" class="form-control" name="threshold_top"
							   required="" value="{{$data->threshold_top}}">
					</div>
					<div class="form-group">
						<input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Ubah">
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

		$('.category').select2({
			selectOnClose: true,
			placeholder: 'Pilih Kategori',
			ajax: {
				url: "{!! url('/') !!}" + '/ajax/category',
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
	</script>
@endpush
