@include('report.header')
<style>
</style>
<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Daftar Harga Jual Per Tanggal {{date("d-m-Y")}}</h4>
    </htmlpageheader>
    <htmlpagefooter name="page-footer">
      </htmlpagefooter>
      <div class="table-responsive">
      <table id="tabels" class="table-sm table-stripped table-bordered  table-hover box">
        <thead>
          <tr>
            <td style="width:auto" class="col-head" >
              No
            </td>
            <td class="col-head" >
            Nama Barang
            </td>

              @if($filter['purchase_price'] == 1)
            <td class="col-head" >
              Harga Beli
            </td>
            @endif
              @if($filter['sell_price'] == 1)
            <td class="col-head" >
              Harga Jual
            </td>
            @endif
          </tr>
        </thead>
        <tbody id="item-table">

       
          @foreach($data as $key)
          <tr onclick="()">
            <td class="">{{$loop->iteration}}</td>
            <td class="">{{$key->item_name}}</td>
            @if($filter['purchase_price'] == 1)
            <td class="">Rp. {{number_format($key->purchase_price)}}</td>
            @endif
              @if($filter['sell_price'] == 1)
             
            <td class="">Rp. {{number_format($key->sell_price)}}</td>
            @endif
          </tr>
          @endforeach

        

        </tbody>
      </table>
      </div>
    </section><!-- /.content -->
    @include('report.footer')
