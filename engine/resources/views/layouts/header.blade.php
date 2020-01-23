


<!-- START HEADER -->
<div class="header ">
  <!-- START MOBILE SIDEBAR TOGGLE -->
  <a href="#" class="btn-link toggle-sidebar hidden-lg-up pg pg-menu" data-toggle="sidebar">
  </a>
  <!-- END MOBILE SIDEBAR TOGGLE -->
  <div class="">
    <div class="brand inline   ">
     <!--  <img src="assets/img/logo.png" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" width="78" height="22"> -->
    </div>

  </div>
  <div class="d-flex align-items-center">
    <!-- START User Info-->
    <div class="pull-left p-r-10 fs-14 font-heading hidden-md-down">
      <span class="semi-bold">{{Auth::User()->displayName}}</span>
    </div>
    <div class="dropdown pull-right hidden-md-down">
      <button class="profile-dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="thumbnail-wrapper d32 circular inline">
          <img src="{{ asset('assets/img/profiles/grey.png') }}" alt="" data-src="{{ asset('assets/img/profiles/grey.png') }}"
          data-src-retina="{{ asset('assets/img/profiles/grey.png') }}" width="32" height="32">
        </span>
      </button>
      <div class="dropdown-menu dropdown-menu-right profile-dropdown" role="menu">
        <a href="#" class="dropdown-item"><i class="pg-settings_small"></i> Settings</a>
        <a href="#" class="dropdown-item"><i class="pg-outdent"></i> Feedback</a>
        <a href="#" class="dropdown-item"><i class="pg-signals"></i> Help</a>
        <a href="#" class="clearfix bg-master-lighter dropdown-item btn-logout">
         <form action="{{ url("logout") }}" method="POST" class="form-logout">
          @csrf
        </form>
        <i class="pg-power"></i> Logout
      </a>
    </div>
  </div>
  <!-- END User Info-->
</div>
</div>
      <!-- END HEADER -->