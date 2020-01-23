@include("header")
<!-- Breadcrumb-->
<div class="breadcrumb-holder">
  <div class="container">
    <ul class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
      <li class="breadcrumb-item active"><a href="{{url('/')}}/pengeluaran">Pengeluaran</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ul>
  </div>
</div>
<section class="forms">
  <div class="container">
    <div class="row">
      <!-- Main content -->
      <section class=" ">
        <div class="col-md-12 box ">
         <p style="color:red">Jika batal mengedit, tutup saja halaman ini. Untuk edit barang silahkan masukan informasi yang benarnya, data otomatis akan ditimpa</p>
         <div class="col-md-12 col-xs-12">
          <form method="post" action="{{url('/')}}/pengeluaran/edit/{{$data->id}}">
            {{csrf_field()}}
            <div class="form-group">
              Nomor Bukti
              <input autocomplete="off" type="text"  class="form-control" name="no_bukti" value="{{$data->no_bukti}}" >
            </div>

            <div class="form-group">
              Tanggal
              <input autocomplete="off" type="date" class="form-control" name="tanggal" value="{{$data->tanggal}}">
            </div>

            <div class="form-group">
              Subjek Pengeluaran
              @if(isset($data->user_id))

              <div class="radio" style="display: inline-flex;">
                <label><button type="button" autocomplete="off" type="radio" class="btn btn-info" id="karyawan">Karyawan</button></label>
                <label><button  type="button" autocomplete="off" type="radio" class="btn btn-info" id="inventaris">Inventaris</button></label>
              </div>
              <div id="suser"  style="">
                <select class="form-control userall" name="user_id" style="width: 100%">
                  <option value="{{$data->user_id->id}}">{{$data->user_id->displayName}}</option>
                </select>
              </div>

              <div id="sinven"  style="display: none">
                <select class="form-control inventoris" name="inventaris"  style="width: 100%">
                </select>
              </div>
              @else

              <div class="radio" style="display: inline-flex;">
                <label><button  type="button" autocomplete="off" type="radio" class="btn btn-info" id="karyawan">Karyawan</button></label>
                <label><button  type="button" autocomplete="off" type="radio" class="btn btn-info" id="inventaris">Inventaris</button></label>
              </div>
              <div id="suser"  style="display: none;">
                <select class="form-control userall" name="user_id" style="width: 100%">
                </select>
              </div>              
              <div id="sinven" >
                <select class="form-control inventoris" name="inventaris"  style="width: 100%">
                  <option value="{{$data->inventoris->id}}">{{$data->inventoris->name}}</option>
                </select>
              </div>
              @endif

            </div>
            <br>
            <div class="form-group">
              Jumlah
              <input autocomplete="off" type="text"  class="form-control" name="jumlah" value="{{$data->jumlah}}">
            </div>

            <div class="form-group">
              @if(Auth::User()->id == 69 ||Auth::User()->id == 70 ||Auth::User()->id == 48||Auth::User()->id == 36||Auth::User()->id == 18)
              Kategori
              <select class="form-control katpeng" name="kategori_pengeluaran_id" style="width: 100%">
                <option value="{{$data->kategori_pengeluaran_id->id}}">{{$data->kategori_pengeluaran_id->name}}</option>
              </select>
              @else
              Kategori
              <select class="form-control katpeng" name="kategori_pengeluaran_id" style="width: 100%">
                <option value="{{$data->kategori_pengeluaran_id->id}}">{{$data->kategori_pengeluaran_id->name}}</option>
              </select>
              @endif
            </div>

            <div class="form-group">
              Detail
              <textarea class="form-control" name="detail">{{$data->detail ?? null}}</textarea>
            </div>

            <div class="form-group">
              <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Edit">
            </div>
          </form>

        </div>
      </div>


    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->

  <!-- Footer -->
  @include('footer')


  <script>
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
  </script>
