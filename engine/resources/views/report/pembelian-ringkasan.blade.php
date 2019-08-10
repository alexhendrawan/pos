@include('report.header')
<section class=" table-responsive">
  <htmlpageheader name="page-header">
    <h4>Laporan Pembelian Per Tanggal {{date("d-m-Y")}}</h4>

    </htmlpageheader>

    <table id="tabel" class="table table-bordered table-hover box">
       <tr>
        <td style="width:auto" class="col-head" >
            No
        </td>
        <td class="col-head" >
            Tanggal Order
        </td>
        <td class="col-head" >
            No Faktur Supp | Kemilau
        </td>
        <td class="col-head" >
            Supplier
        </td>
        <td class="col-head" >
            Total
        </td>
        <td class="col-head" >
            Retur
        </td>
        <td class="col-head" >
            Netto
        </td>
        <td class="col-head" >
            Total Bayar
        </td>
        <td class="col-head" >
            Sisa Bayar
        </td>
    </tr>

    <tbody id="item-table"> 
        @php
        $totalhutang = 0;
        @endphp
        @foreach($data as $key)
        <tr onclick="({{$key -> id}})">
            <td class="">{{$loop->iteration}}</td>
            <td>{{date("d-m-Y",strtotime($key->tgl))}}</td>
            <td>{{$key->supplier_invoice_no}} | {{$key->internal_invoice_no}} </td>
            <td>{{$key->supplier_name}}</td>
            <td class="printAngka">{{$key->invoice_total + - $key->retur}}</td>
            <td class="printAngka">{{$key->retur}}</td>
            <td class="printAngka">{{$key->invoice_total}}</td>

            <td class="printAngka">{{$key->po_total_paid}}</td>
            <td class="printAngka">{{$key->invoice_total - $key->po_total_paid}}</td>
            @php
            $totalhutang+=$key->invoice_total - $key->po_total_paid;
            @endphp
        </tr>
        @endforeach
        <tr class="">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="">Total Hutang</td>

        </tr>
        <tr class="">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="printAngka">{{$totalhutang}}</td>

        </tr>

    </tbody>
</table>
</section><!-- /.content -->
@include('report.footer')
