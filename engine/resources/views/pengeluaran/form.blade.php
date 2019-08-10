@extends("layouts.main")
@section("title")
Pengeluaran
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<section class=" table-responsive">
			<form method="post" action="{{url('/')}}/pengeluaran">
				{{csrf_field()}}
				<div class="form-group">
					Nomor Bukti
					<input autocomplete="off" type="text" class="form-control" name="no_bukti">
				</div>

				<div class="form-group">
					Tanggal
					<input autocomplete="off" type="date" class="form-control" name="tanggal" value="{{date('Y-m-d')}}">
				</div>

				<div class="form-group">
					Subjek Pengeluaran
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
					<input autocomplete="off" type="text" class="form-control" name="jumlah">
				</div>
				<input type="hidden" name="bankcash_id" value="1">
				<div class="form-group">
					@if(Session()->get("user")->id == 69 ||Session()->get("user")->id == 70 ||Session()->get("user")->id
					== 48||Session()->get("user")->id == 36||Session()->get("user")->id == 18)
					Kategori
					<select class="form-control katpengadmin" name="kategori_pengeluaran_id"
						style="width: 100%"></select>
					@else
					Kategori
					<select class="form-control katpeng" name="kategori_pengeluaran_id" style="width: 100%"></select>
					@endif
				</div>

				<div class="form-group">
					Detail
					<textarea class="form-control" name="detail"></textarea>
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
	$('.userall').select2({
    selectOnClose: true,
    placeholder: 'Pilih Karyawan',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/user',
      dataType: 'json',
      delay: 600,
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

  $('.katpengadmin').select2({
    selectOnClose: true,
    placeholder: 'Pilih Kategori Pengeluaran',
    ajax: {
      url: "{!! url('/') !!}" + '/ajax/kategori-pengeluaran',
      dataType: 'json',
      delay: 600,
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
