<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta charset="utf-8" />
  <title>CV. Kemilau Mentari</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no" />
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
  <link href="{{ asset("assets/plugins/pace/pace-theme-flash.css") }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset("assets/plugins/boostrapv3/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset("assets/plugins/font-awesome/css/font-awesome.css") }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset("assets/plugins/jquery-scrollbar/jquery.scrollbar.css") }}" rel="stylesheet" type="text/css" media="screen" />
  <link href="{{ asset("assets/plugins/bootstrap-select2/select2.css") }}" rel="stylesheet" type="text/css" media="screen" />
  <link href="{{ asset("assets/plugins/switchery/css/switchery.min.css") }}" rel="stylesheet" type="text/css" media="screen" />
  <link href="{{ asset("pages/css/pages-icons.css") }}" rel="stylesheet" type="text/css">
  <link class="main-stylesheet" href="{{ asset("pages/css/pages.css") }}" rel="stylesheet" type="text/css" />
    <!--[if lte IE 9]>
        <link href="pages/css/ie9.css" rel="stylesheet" type="text/css" />
      <![endif]-->
      <script type="text/javascript">
        window.onload = function()
        {
      // fix for windows 8
      if (navigator.appVersion.indexOf("Windows NT 6.2") != -1)
        document.head.innerHTML += '<link rel="stylesheet" type="text/css" href="pages/css/windows.chrome.fix.css" />'
    }
  </script>
</head>
<body class="fixed-header ">

  <div class="login-wrapper ">

    <!-- START Login Background Pic Wrapper-->
    <div class="bg-pic  " >
      {{-- <img src="{{ asset("assets/image/bg.jpg") }}" data-src="{{ asset("assets/image/bg.jpg") }}" data-src-retina="{{ asset("assets/image/bg.jpg") }}" alt="" class="lazy" style="width: 65%; height: auto; opacity:1"> --}}
    </div>
    <!-- END Login Background Pic Wrapper-->
    <!-- START Login Right Container-->
    <div class="login-container bg-white">
     @if (session('message'))
     <div class="alert alert-success alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {!! session('message') !!}
    </div>
    @endif @if (session('error'))
    <div class="alert alert-danger alert-dismissible">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {!! session('error') !!}
    </div>
    @endif
    <div class="p-l-50 m-l-20 p-r-50 m-r-20 p-t-50 m-t-30 sm-p-l-15 sm-p-r-15 sm-p-t-40">
      <h2 class="p-t-35">CV. Kemilau Mentari</h2>
      <!-- START Login Form -->
      
      <form method="POST" action="{{ route('login') }}">

        @csrf
        <!-- START Form Control-->
        <div class="form-group form-group-default">
          <label>Login</label>
          <div class="controls">
            <input type="text" name="username" placeholder="Username" class="form-control" required>
          </div>
        </div>
        <!-- END Form Control-->
        <!-- START Form Control-->
        <div class="form-group form-group-default">
          <label>Password</label>
          <div class="controls">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
          </div>
        </div>
        <!-- START Form Control-->
        <div class="row hide">
          <div class="col-md-6 no-padding">
            <div class="checkbox ">
              <input type="checkbox" value="1" id="checkbox1">
              <label for="checkbox1">Keep Me Signed in</label>
            </div>
          </div>
          <div class="col-md-6 text-right">
          </div>
        </div>
        <!-- END Form Control-->
        <button class="btn btn-primary btn-cons m-t-10 log_in" type="submit">Sign in</button>
      </form>
      <!--END Login Form-->
      <div class="pull-bottom sm-pull-bottom">
        <div class="m-b-30 p-r-80 sm-m-t-20 sm-p-r-15 sm-p-b-20 clearfix">
          <div class="col-sm-3 col-md-2 no-padding">
            <img alt="" class="m-t-5" data-src="" data-src-retina="" height="60" src="" width="60">
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END Login Right Container-->
</div>

<!-- BEGIN VENDOR JS -->
<script src="{{ asset("assets/plugins/pace/pace.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/jquery/jquery-1.11.1.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/modernizr.custom.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/jquery-ui/jquery-ui.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/boostrapv3/js/bootstrap.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/jquery/jquery-easy.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/jquery-unveil/jquery.unveil.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/jquery-bez/jquery.bez.min.js") }}"></script>
<script src="{{ asset("assets/plugins/jquery-ios-list/jquery.ioslist.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/jquery-actual/jquery.actual.min.js") }}"></script>
<script src="{{ asset("assets/plugins/jquery-scrollbar/jquery.scrollbar.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/plugins/bootstrap-select2/select2.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/plugins/classie/classie.js") }}"></script>
<script src="{{ asset("assets/plugins/switchery/js/switchery.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/plugins/jquery-validation/js/jquery.validate.min.js") }}" type="text/javascript"></script>
<!-- END VENDOR JS -->
<script src="{{ asset("pages/js/pages.min.js") }}"></script>
<script>
  $(function()
  {
    $('#form-login').validate()
  })
</script>
</body>
</html>
