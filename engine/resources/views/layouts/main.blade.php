<!DOCTYPE html>
<html>

<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<meta charset="utf-8" />
	<title>@yield("title") - CV. Kemilau Mentari</title>

	<meta name="viewport"
		content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
	<link rel="apple-touch-icon" href="pages/ico/60.png">
	<link rel="apple-touch-icon" sizes="76x76" href="pages/ico/76.png">
	<link rel="apple-touch-icon" sizes="120x120" href="pages/ico/120.png">
	<link rel="apple-touch-icon" sizes="152x152" href="pages/ico/152.png">
	<link rel="icon" type="image/x-icon" href="favicon.ico" />
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-touch-fullscreen" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="default">
	<meta content="" name="description" />
	<meta content="" name="author" />
	{{-- <link href="{{ asset('assets/plugins/pace/pace-theme-flash.css') }}" rel="stylesheet" type="text/css" /> --}}
	<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.css') }}" rel="stylesheet" type="text/css"
		media="screen" />
	<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css"
		media="screen" />
	<link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"
		media="screen" />
	{{-- <link href="{{ asset('assets/plugins/switchery/css/switchery.min.css') }}" rel="stylesheet" type="text/css"
	media="screen" /> --}}
	<link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet" type="text/css"
		media="screen">
	<link href="{{ asset('pages/css/pages-icons.css') }}" rel="stylesheet" type="text/css">
	<link class="main-stylesheet" href="{{ asset('pages/css/pages.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/vendor/font-awesome/all.min.css') }}" rel="stylesheet" type="text/css">
	@stack("css");
</head>

<body class="fixed-header dashboard">
	@include("layouts.sidebar")

	<div class="page-container ">
		@include("layouts.header")
		<div class="page-content-wrapper ">

			<div class="content sm-gutter">
				<div class="jumbotron" data-pages="parallax">
					<div class="container-fluid container-fixed-lg sm-p-l-20 sm-p-r-20">

						<div class="inner">
							<h1>@yield("title")</h1>
						</div>
					</div>
				</div>

				<div class="container-fluid">
					@if (session('message'))
					<div class="alert alert-success alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {!!
						session('message') !!}
					</div>
					@endif @if (session('error'))
					<div class="alert alert-danger alert-dismissible">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {!!
						session('error') !!}
					</div>
					@endif
					<div class="card">
						<div class="card-body">
							<div class="panel">
								<div class="panel-body">
									@yield("content")
								</div>
							</div>
						</div>
					</div>

				</div>


			</div>



			<div class="container-fluid container-fixed-lg footer">
				<div class="copyright sm-text-center">
					<p class="small no-margin pull-left sm-pull-reset">
						<span class="hint-text">Copyright &copy; 2017-{{ date("Y") }} </span>
						<a href="https://wtd-studio.com" target="_BLANK" class="font-montserrat">WTD-STUDIO</a>.
						<span class="hint-text">All rights reserved. </span>
					</p>
					<p class="small no-margin pull-right sm-pull-reset">
					</p>
					<div class="clearfix"></div>
				</div>
			</div>


		</div>
	</div>

	<script type="text/javascript">
		var baseUrl = "{{ getenv("BASEURL_API") }}";
	</script>


	<script src="{{ asset('assets/plugins/jquery/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/modernizr.custom.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/tether/js/tether.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('pages/js/pages.min.js') }}"></script>
	<script src="{{ asset('assets/js/scripts.js') }}" type="text/javascript"></script>
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/plugins/sweetalert2/sweetalert2.all.js')}}" type="text/javascript"></script>
	@stack("js")

	<script type="text/javascript">
		function number_format(number, decimals, dec_point, thousands_sep) {
  number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
  prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
  sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
  dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
  s = '',
  toFixedFix = function (n, prec) {
    var k = Math.pow(10, prec);
    return '' + Math.round(n * k) / k;
  };
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  // if ((s[1] || '').length < prec) {
    //   s[1] = s[1] || '';
    //   s[1] += new Array(prec - s[1].length + 1).join('0');
    // }
    return s.join(dec);
  }

  var classUang = document.getElementsByClassName("printUang");
  if (classUang.length > 0) {
    for (var i = 0; i < classUang.length; i++) {
      var val = classUang[i].innerHTML;
      if (val != '' && val != null && !isNaN(val)) {
        val = parseFloat(classUang[i].innerHTML);
        var res = "Rp. " + number_format(val, 2, ",", ".");
        classUang[i].innerHTML = res;
      }
    }
  }

  var classAngka = document.getElementsByClassName("");
  if (classAngka.length > 0) {
    for (var i = 0; i < classAngka.length; i++) {
      var val = classAngka[i].innerHTML;
      if (val != '' && val != null && !isNaN(val)) {
        val = parseFloat(classAngka[i].innerHTML);
        var res = number_format(val, 0, ",", ".");
        classAngka[i].innerHTML = res;
      }
    }
  }

  function addDecimal(val) {
    var value = "Rp. " + number_format(val, 2, ",", ".");
    return value;
  }

  function updateRowOrder() {
    $('.number').each(function (i) {
      $(this).text(i + 1);
    });
    $('tr.id').each(function (i) {
      $(this).attr('id', i + 1);
    });
  }

  function formatDate(date) {
    var mydate = new Date(date);
    var month = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"][mydate.getMonth()];
    var str = mydate.getDate() + '-' + month + '-' + mydate.getFullYear();
    return str;
  }


  function konfirmasi(id, url) {
    swal({
      title: 'Konfirmasi',
      text: "Anda akan menghapus baris ini",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya Hapus',
      showLoaderOnConfirm: true,
      preConfirm: () => {
       $.ajax({
         headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "delete",
        url: "{!! url("/") !!}" + "/" + url + "/" + id,
        cache: false,
        success: function(response) {

        },
        failure: function (response) {
          swal.showValidationError(
            `Data Dipakai Di Tempat Lain`
            )
        }
      });
     }, allowOutsideClick: () => !swal.isLoading()
   }).then((result) => {
    if (result.value) {
      swal({
        title: 'Data Dihapus',
        text: 'Memuat Ulang Data',
        type: 'success',
        showConfirmButton: false,
        timer: 1500,
      }).then((result) => {
        location.reload();
      })
    } else {
      swal({
        type: 'error',
        title: 'Data Tidak Dihapus',
        text: 'Tombol Cancel Ditekan',
      })
    }
  });
 }

 $(".btn-logout").click(function () {
  $(".form-logout").submit();
})

 function detail (id, url){
  window.location = "{{url('/')}}/"+url+"/" + id;
}
function printfaktur(id, url){
  $.ajax({
    url: "{!! url('/') !!}/print/faktur/"+url+"/" + id,
    method: "get",
    success: function (response) {
      alert("Sedang mengirimkan perintah");
    },
    error: function (xhr, statusCode, error) {
      alert(error);
    }
  });
}
	</script>

	<script src="{{asset('assets/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/plugins/datatables/datatables.init.js')}}" type="text/javascript"></script>>

</body>

</html>
