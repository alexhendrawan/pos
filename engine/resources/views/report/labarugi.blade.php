@include('report.header')

<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <div class="col-md-12" style="text-align: center">
      <h2>CV. Kemilau Mentari</h2>
      <h4 style="">Laporan Laba Rugi </h4>
      <h4>{{date("d-m-Y",strtotime($tanggalstart))}} - {{date("d-m-Y",strtotime($tanggalend))}}</h4>
    </div>
    </htmlpageheader>

    <!-- Main content -->
    <section class=" table-responsive">
      <div class="table-responsive col-md-8 offset-2">
        <table class="table table-bordered">
          <tr>
            <td>Penjualan</td>
            <td class="printUang">{{$datapenjualan->totalsales}}</td>
          </tr>

          <tr>
            <td>Modal Penjualan</td>
            <td class="printUang">{{$datapenjualan->modal}}</td>
          </tr>

          <tr>
            <td><strong>Laba Kotor</strong></td>
            <td class="printUang" style="font-weight: 800">{{$datapenjualan->totalsales-$datapenjualan->modal}}</td>
          </tr>
          <tr>
            <td></td>
            <td class="printUang"></td>
          </tr>
          <tr class="d-none">
            <td>Beban Pembelian</td>
            <td class="printUang">{{$datapembelian->invoice_total}}</td>
          </tr>

          <tr>
            <td>Beban Pengeluaran</td>
            <td class="printUang">{{$datapengeluaran->totalpengeluaran}}</td>
          </tr>

          <tr>
            <td>Beban Komisi</td>
            <td class="printUang">{{$datapenjualan->totalsales * 0.008}}</td>
          </tr>
          <tr>
            <td>Total</td>
            <td class="printUang">{{$datapengeluaran->totalpengeluaran + ($datapenjualan->totalsales * 0.008)}}</td>
          </tr>
          <tr>
            <td><strong>Laba Bersih</strong></td>
            <td class="printUang" style="font-weight: 800">{{($datapenjualan->totalsales-$datapenjualan->modal)-($datapengeluaran->totalpengeluaran + ($datapenjualan->totalsales * 0.008))}}</td>
          </tr>
        </table>
      </div>
    </section><!-- /.content -->



    <!-- Footer -->
    @include('report.footer')
