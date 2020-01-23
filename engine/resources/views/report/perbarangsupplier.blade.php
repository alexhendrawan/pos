@include('report.header')
<style>
</style>
<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Laporan Pembelian Per Tanggal {{date("d-m-Y",strtotime($start)) ." - ". date("d-m-Y",strtotime($end))}}</h4>
    @if(isset($customer->name ))
    Pelanggan : <h5>{{$customer->name ?? null}}</h5>
    @endif

    @if(isset($namasales->displayName ))
    Sales : <h5>{{$namasales->displayName ?? null}}</h5>
    @endif
    @if(isset($data[0]->supplier_name))
    Supplier :<h5>{{$data[0]->supplier_name ?? null}}</h5>
    @endif
    @if(isset($data[0]->item_name) && isset($s) != false)
    Barang :<h5>{{$data[0]->item_name ?? null}}</h5>
    @endif
  </htmlpageheader>
  <htmlpagefooter name="page-footer">
  </htmlpagefooter>
  <table id="tabel" class="table-sm table-stripped table-bordered  table-hover box">
    <thead>
      <tr>
        <td style="width:auto" class="col-head">
          No
        </td>
        <td class="col-head">
          No Faktur Internal
        </td>
        <td class="col-head">
          No Faktur Supplier
        </td>
        <td class="col-head">
          Tanggal Order
        </td>
        <td class="col-head">
          Supplier
        </td>
        <td class="col-head">
          Barang
        </td>
        <td class="col-head">
          Harga Satuan
        </td>
        <td class="col-head">
          Qty
        </td>
        <td class="col-head">
          Harga Total
        </td>

      </tr>

    </thead>

    <tbody id="item-table">
      @php
      $qty = 0;
      $total = 0;
      @endphp

      @foreach($data as $key)
      @php
      $qty +=$key->beli;
      $total +=($key->beli * $key->hargabeli);
      @endphp
      <tr onclick="()">
        <td class="">{{$loop->iteration}}</td>
        <td>{{$key->internal_invoice_no}}</td>
        <td>{{$key->supplier_invoice_no}}</td>
        <td>{{date("d-m-Y",strtotime($key->tglbeli))}}</td>
        <td>{{$key->supplier_name}}</td>
        <td class="">{{$key->item_name}}</td>
        <td class="printAngka">{{$key->hargabeli}}</td>
        <td class="printAngka">{{$key->beli}}</td>
        <td class="printAngka">{{($key->beli * $key->hargabeli)}}</td>

      </tr>
      @endforeach

      <tr onclick="()">
        <td class=""></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="printAngka">{{$qty}}</td>
        <td class="printAngka">{{$total}}</td>
      </tr>

    </tbody>
  </table>
</section><!-- /.content -->
@include('report.footer')