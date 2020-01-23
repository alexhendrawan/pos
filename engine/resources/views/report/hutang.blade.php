@include('report.header')

<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Laporan Hutang Per Tanggal {{$tanggalstart}} - {{$tanggalend}}</h4>

  </htmlpageheader>


  <!-- Main content -->
  <section class=" table-responsive">
    <h4></h4>
    <table id="tabel" class="table table-bordered table-hover box">
      <thead>
        <tr>
          <td class="col-head">
            No

          </td>

          <td class="col-head">
            Supplier

          </td>


          <td class="col-head">
            Total Tagihan

          </td>

          <td class="col-head">
            Total Retur

          </td>
          <td class="col-head">
            Total bayar

          </td>
          <td class="col-head">
            Sisa Bayar

          </td>
        </tr>

      </thead>
      <tbody id="item-table"> <?php $totaltagihan = 0; $totalbayar=0; $totalsisabayar=0; $totalretur = 0?>
        @foreach($data as $key)
        @php
        $totaltagihan += $key->invoice_total + $key->retur;
        $totalretur += $key->retur;
        $totalbayar += $key->paid_total;
        $totalsisabayar += $key->invoice_total - $key->paid_total;
        @endphp
        <tr>
          <td onclick="" class="">{{$loop->iteration}}</td>
          <td>{{$key->supplier_name}}</td>
          <td class="printAngka">{{$key->invoice_total}}</td>
          <td class="printAngka">{{$key->retur}}</td>
          <td class="printAngka">{{$key->paid_total}}</td>
          <td class="printAngka">{{$key->invoice_total + $key->retur - $key->paid_total}}</td>

        </tr>
        @endforeach
        <tr>
          <td onclick="" class=""></td>
          <td onclick=""></td>
          <td class="col-head">
            Total Tagihan

          </td>

          <td class="col-head">
            Total Retur

          </td>
          <td class="col-head">
            Total bayar

          </td>
          <td class="col-head">
            Sisa Bayar

          </td>
        </tr>
        <tr>
          <td onclick="" class=""></td>
          <td onclick=""></td>
          <td onclick="" class="printAngka">{{$totaltagihan}}</td>
          <td onclick="" class="printAngka">{{$totalretur}}</td>
          <td onclick="" class="printAngka">{{$totalbayar}}</td>
          <td onclick="" class="printAngka">{{$totalsisabayar}}</td>
        </tr>
      </tbody>
    </table>
  </section><!-- /.content -->
  </div><!-- /.content-wrapper -->


  <!-- Footer -->
  @include('report.footer')