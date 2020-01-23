@extends("layouts.main")
@section("title")
Pengeluaran
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class=" table-responsive">
			<form method="POST" action="{{url('/')}}/pengeluaran/{{$data->id}}">
				{{csrf_field()}}
        @method("PUT")
				<div class="form-group">
					Nomor Bukti
					<input autocomplete="off" type="text" class="form-control" name="no_bukti" value="{{$data->no_bukti}}">
				</div>

				<div class="form-group">
					Tanggal
					<input autocomplete="off" type="date" class="form-control" name="tanggal" value="{{date('Y-m-d', strtotime($data->tanggal))}}">
				</div>

				<div class="form-group">
					Subjek Pengeluaran (Di isi Ulang)
					<div class="radio" style="display: inline-flex;">
						<label><button type="button" autocomplete="off" type="radio" class="btn btn-info"
								id="karyawan">Karyawan</button></label>
						<label><button type="button" autocomplete="off" type="radio" class="btn btn-info"
								id="inventaris">Inventaris</button></label>
					</div>
					<div id="suser" style="">
						<select class="form-control userall" name="user_id" style="width: 100%">

						</select>
					</div>

					<div id="sinven" style="display: none">
						<select class="form-control inventaris" name="inventaris_id" style="width: 100%">
						</select>
					</div>
				</div>
				<br>
				<div class="form-group">
					Jumlah
					<input autocomplete="off" type="text" class="form-control" name="jumlah" value="{{$data->jumlah}}">
				</div>
				<input type="hidden" name="bankcash_id" value="1">
				<div class="form-group"> 
					@if(Auth::User()->id == 69 ||Auth::User()->id == 70 ||Auth::User()->id
					== 48||Auth::User()->id == 36||Auth::User()->id == 18)
					Kategori (Diisi Ulang)
					<select class="form-control katpengadmin" name="kategori_pengeluaran_id"
						style="width: 100%"></select>
					@else
					Kategori (Diisi Ulang)
					<select class="form-control katpeng" name="kategori_pengeluaran_id" style="width: 100%"></select>
					@endif
				</div>

				<div class="form-group">
					Detail
					<textarea class="form-control" name="detail">{{$data->detail}}</textarea>
				</div>

				<div class="form-group">
					<input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Edit">
				</div>
			</form>
		</section><!-- /.content -->
	</div>
</div>
@endsection

@push("js")

<script>
	$('.userall').select2({
    selectOnClose: true,
    placeholder: 'Pilih Karyawan',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/user',
      dataType: 'json',
      delay: 1000,
      processResults: function (data) {

        return {
          results: $.map(data, function (item) {

            return {
              text: item.displayName,
              id: item.id

            }

          })

        };
      },
      cache: true

    }

  });


 $('.inventaris').select2({
    selectOnClose: true,
    placeholder: 'Pilih Inventaris',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/inventaris',
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

  $("#karyawan").click(function(){
    $("#sinven").hide();
    $("#suser").show();
    $(".inventoris").val(null).trigger('change');

  })


  $("#inventaris").click(function(){
    $("#sinven").show();
    $("#suser").hide();
    $(".userall").val(null).trigger('change');

  })


  $('.katpeng').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kategori Pengeluaran',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/kategori-pengeluaran',
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

  $('.katpengadmin').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kategori Pengeluaran',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/kategori-pengeluaran',
      dataType: 'json',
      delay: 1000,
      processResults: function (data) {

        return {
          results: $.map(data, function (item) {
           if(item.name != "Gaji" && item.name != "Komisi" && item.name != "Thr"){
            return {
              text: item.name,
              id: item.id

            }
          }
        })

        };
      },
      cache: true

    }

  });


</script>

@endpush
