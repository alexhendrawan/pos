@include('report.header')
<style>
</style>
<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Laporan Penjualan Per Tanggal {{date("d-m-Y",strtotime($start)) ." - ". date("d-m-Y",strtotime($end))}}</h4>
    @if(isset($customer->name ))
    Pelanggan : <h5>{{$customer->name ?? null}}</h5>
    @endif

    @if(isset($namasales->displayName ))
    Sales : <h5>{{$namasales->displayName ?? null}}</h5>
    @endif

    @if(!isset($filter) && isset($data[0]->item_name))
    Barang:<h5>{{$data[0]->item_name ?? null}}</h5>
    @endif
    </htmlpageheader>
    <htmlpagefooter name="page-footer">
      </htmlpagefooter>
      <table id="tabel" class="table-sm table-stripped table-bordered  table-hover box">
        <thead>
          <tr>
            <td style="width:auto" class="col-head" >
              No
            </td>
            <td class="col-head" >
              No Faktur
            </td>
            <td class="col-head" >
              Tanggal Order
            </td>
            <td class="col-head" >
              Konsumen
            </td>
            <td class="col-head" >
              Barang
            </td>
            <td class="col-head" >
              Harga Satuan
            </td>
            <td class="col-head" >
              Qty
            </td>
            <td class="col-head" >
              Diskon
            </td>
            <td class="col-head" >
              Retur
            </td>
            <td class="col-head" >
              Harga Total
            </td>

          </tr>

        </thead>
        <tbody id="item-table">
          @php
          $qty = 0;
          $diskon = 0;
          $retur = 0;
          $total = 0;
          @endphp

          @foreach($data as $key)
          @php
          $qty +=$key->beli;
          $diskon +=$key->diskon;
          $retur +=$key->retur;
          $total +=($key->beli * $key->sell_price)-$key->diskon-$key->retur;
          @endphp
          <tr onclick="()">
            <td class="">{{$loop->iteration}}</td>
            <td>{{$key->intnomorsales}}</td>
            <td>{{date("d-m-Y",strtotime($key->tanggalorder))}}</td>
            <td>{{$key->customername}}</td>
            <td class="">{{$key->item_name}}</td>
            <td class="printAngka">{{$key->sell_price}}</td>
            <td class="printAngka">{{$key->beli}}</td>
            <td class="printAngka">{{$key->diskon}}</td>
            <td class="printAngka">{{$key->retur}}</td>
            <td class="printAngka">{{($key->beli * $key->sell_price)-$key->diskon-$key->retur}}</td>

          </tr>
          @endforeach

          <tr onclick="()">
            <td class=""></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="printAngka">{{$qty}}</td>
            <td class="printAngka">{{$diskon}}</td>
            <td class="printAngka">{{$retur}}</td>
            <td class="printAngka">{{$total}}</td>
          </tr>

        </tbody>
      </table>
    </section><!-- /.content -->
    @include('report.footer')
