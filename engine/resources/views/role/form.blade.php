@extends("layouts.main")
@section("title")
Role
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<form action="{{url('/')}}/role" method="POST">
			{{csrf_field()}}
			<div class="form-group">
				Nama Role
				<input autocomplete="off" type="text" name="name" class="form-control">
			</div>
			<input autocomplete="off" type="submit" class="btn btn-info" name="">
		</form>
	</div>
</div>
@endsection