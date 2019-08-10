@include('report.header')

<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Laporan Piutang Per Tanggal {{$tanggalstart}} - {{$tanggalend}}</h4>
    @if(isset($user))
    <h5>Sales: {{$user->displayName}}</h5>
    @endif

    @if(isset($customer))
    <h5>Konsumen: {{$customer->name}}</h5>
    @endif
    </htmlpageheader>


    <!-- Main content -->
    <section class=" table-responsive">
      <h4></h4>
      <table id="tabel" class="table table-bordered table-hover box">
        <thead>
          <tr>
            <td class="col-head" >
              No

            </td>

            <td class="col-head" >
              Customer

            </td>


            <td class="col-head" >
              Total Tagihan

            </td>

            <td class="col-head" >
              Total Retur

            </td>
            <td class="col-head" >
              Total bayar

            </td>
            <td class="col-head" >
              Sisa Bayar

            </td>


          </thead>
          <tbody id="item-table"> <?php $totaltagihan = 0; $totalbayar=0; $totalsisabayar=0; $totalretur = 0?>
            @foreach($data as $key)
            <?php
            $totaltagihan +=$key->totalsales;
            $totalbayar +=$key->totalpaid;
            $totalsisabayar +=$key->paymentremain;
            $totalretur +=$key->retur;
            ?>
            <tr >
              <td onclick="" class="">{{$loop->iteration}}</td>
              <td>{{$key->name}}</td>
              <td class="printAngka">{{$key->totalsales}}</td>
              <td class="printAngka">{{$key->retur}}</td>
              <td class="printAngka">{{$key->totalpaid}}</td>
              <td class="printAngka">{{$key->paymentremain}}</td>

            </tr>
            @endforeach
            <tr >
              <td onclick="" class=""></td>
              <td onclick=""></td>
              <td onclick="" class="printAngka">{{$totaltagihan}}</td>
              <td onclick="" class="printAngka">{{$totalretur}}</td>
              <td onclick=""class="printAngka">{{$totalbayar}}</td>
              <td onclick="" class="printAngka">{{$totalsisabayar}}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td class="col-head" >
                No

              </td>

              <td class="col-head" >
                Customer

              </td>


              <td class="col-head" >
                Total Tagihan

              </td>

              <td class="col-head" >
                Total Retur

              </td>
              <td class="col-head" >
                Total bayar

              </td>
              <td class="col-head" >
                Sisa Bayar

              </td>


            </tfoot>
          </table>
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


      <!-- Footer -->
      @include('report.footer')
