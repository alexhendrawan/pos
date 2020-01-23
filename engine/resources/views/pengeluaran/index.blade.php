@extends("layouts.main")
@section("title")
Pengeluaran
@endsection
@section("content")
<div class="page-content-wrapper">
  <div class="container-fluid">
    <section class=" table-responsive">
      <div class="row d-none">
        <form class="col-md-6" action="{{ url("pengeluaran") }}">
          <input type="date" name="date_start" value="{{$data->date_start ?? "" }}">
          -
          <input type="date" name="date_end" value="{{ $data->date_end ?? "" }}">
          <input type="submit" name="" value="Submit!">
        </form>

      </div>


      <table id="tabel" class="table table-bordered table-hover box">
        <thead>
          <th class="col-head" >
            No

          </th>
          <th class="col-head" >
            Tanggal
          </th>
          <th class="col-head" >
            Nomor Bukti
          </th>


          <th class="col-head" >
            Subjek Pengeluaran
          </th>

          <th class="col-head" >
            Jumlah
          </th>

          <th class="col-head" >
            Kategori
          </th>

          <th class="col-head" >
            Catatan
          </th>

          <th class="col-head" >
            Action

          </th>

        </thead>
          @forelse($data->content as $key)

          @if((Auth::User()->id == 69 ||Auth::User()->id == 70 ||Auth::User()->id == 48||Auth::User()->id == 36||Auth::User()->id == 18)&&($key->kategori->name =="Gaji" || $key->kategori->name =="Komisi" || $key->kategori->name =="Thr"))

          @else
          <tr>
            <td class="">{{$loop->iteration}}</td>
            <td>{{date("d-m-Y",strtotime($key->tanggal))}}</td>
            <td>{{$key->no_bukti ?? "-"}}</td>
            <td>{{$key->inventaris->name ?? $key->user->displayName ?? "-"}}</td>
            <td class="printUang">{{$key->jumlah}}</td>
            <td>{{$key->kategori->name}}</td>
            <td>{{$key->detail ?? "-"}}</td>
            <td>
              <div id="menutable">
                <a href="<?php echo url("/") ?>/pengeluaran/{{$key->id}}" class="btn btn-xs btn-success dis" style="width: 100%">Edit</a>
                <button class="btn btn-xs btn-danger dis" onclick="konfirmasi({{$key->id}},'pengeluaran')" style="width: 100%">Delete</button>
              </div>
            </td>
          </tr>
          @endif
          @endforeach

        </tbody>
      </table>
    </section><!-- /.content -->
  </div>
</div>
@endsection


