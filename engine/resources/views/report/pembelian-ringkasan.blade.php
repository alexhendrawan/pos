@include('report.header')
<section class=" table-responsive">
    <htmlpageheader name="page-header">
        <h4>Laporan Pembelian Per Tanggal {{date("d-m-Y")}}</h4>

    </htmlpageheader>

    <table id="tabel" class="table table-bordered table-hover box">
        <tr>
            <td style="width:auto" class="col-head">
                No
            </td>
            <td class="col-head">
                Tanggal Order
            </td>
            <td class="col-head">
                No Faktur Supp | Kemilau
            </td>
            <td class="col-head">
                Supplier
            </td>
            <td class="col-head">
                Total
            </td>
            <td class="col-head">
                Retur
            </td>
            <td class="col-head">
                Netto
            </td>
            <td class="col-head">
                Total Bayar
            </td>
            <td class="col-head">
                Sisa Bayar
            </td>
        </tr>

        <tbody id="item-table">
            @php
            $a = 0;
            $b = 0;
            $c = 0;
            $d = 0;
            $e = 0;
            @endphp
            @foreach($data as $key)
            <tr onclick="({{$key -> id}})">
                <td class="">{{$loop->iteration}}</td>
                <td>{{date("d-m-Y",strtotime($key->tgl))}}</td>
                <td>{{$key->supplier_invoice_no}} | {{$key->internal_invoice_no}} </td>
                <td>{{$key->supplier_name}}</td>
                <td class="printAngka">{{$key->invoice_total + $key->retur}}</td>
                <td class="printAngka">{{$key->retur}}</td>
                @if($key->retur == 0)
                <td class="printAngka">{{$key->invoice_total}}</td>
                @else
                <td class="printAngka">{{$key->invoice_total + $key->retur}}</td>
                @endif
                <td class="printAngka">{{$key->po_total_paid}}</td>
                @if($key->retur == 0)
                <td class="printAngka">{{$key->invoice_total - $key->po_total_paid }}</td>
                @else
                <td class="printAngka">{{($key->invoice_total+ + $key->retur) - $key->po_total_paid}}</td>
                @endif
                @php
                $a += $key->invoice_total - $key->retur;
                $b += $key->retur;
                $c += $key->invoice_total;
                $d += $key->po_total_paid;
                $e += $key->invoice_total - $key->po_total_paid;
                @endphp
            </tr>
            @endforeach
            <tr>
                <td style="width:auto" class="col-head">
                </td>
                <td class="col-head">
                </td>
                <td class="col-head">
                </td>
                <td class="col-head">
                </td>
                <td class="col-head">
                    Total
                </td>
                <td class="col-head">
                    Retur
                </td>
                <td class="col-head">
                    Netto
                </td>
                <td class="col-head">
                    Total Bayar
                </td>
                <td class="col-head">
                    Sisa Bayar
                </td>
            </tr>
            <tr class="">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="printAngka">{{$a}}</td>
                <td class="printAngka">{{$b}}</td>
                <td class="printAngka">{{$c}}</td>
                <td class="printAngka">{{$d}}</td>
                <td class="printAngka">{{$e}}</td>

            </tr>

        </tbody>
    </table>
</section><!-- /.content -->
@include('report.footer')