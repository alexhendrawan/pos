@extends("layouts.main")
@section("title")
Stok
@endsection
@section("content")
@php
$qty = 0;
@endphp
<div class="page-content-wrapper">
    <div class="container-fluid">
        <section class="table-responsive">
            Stock Opname:
            <table class="table table-bordered table-stripped">
                <thead>
                    <th>Tanggal</th>
                    <th>Qty</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$data->opname->createdOn ?? "Tidak Ada Data"}}</td>
                        <td>{{$data->opname->qty ?? 0}}</td>
                        @php
                        $qty = $data->opname->qty ?? 0;
                        @endphp
                    </tr>
                </tbody>
            </table>
            Penjualan:
            <table class="table table-bordered table-stripped">
                <thead>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Qty</th>
                    <th>Detail</th>
                </thead>
                <tbody>
                    @forelse($data->penjualan as $penjualan)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$penjualan->createdOn}}</td>
                        <td>{{$penjualan->qty}}</td>
                        <td><a href="{{url('penjualan')}}/{{$penjualan->sales_order_header_id}}">Detail</a></td>
                    </tr>
                    @php
                    $qty -= $penjualan->qty;
                    @endphp
                    @empty
                    <tr>
                        <td>1</td>
                        <td>Tidak Ada Data</td>
                        <td>0</td>
                        @endforelse
                    </tr>
                </tbody>
            </table>
            Pembelian:
            <table class="table table-bordered table-stripped">
                <thead>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Qty</th>
                </thead>
                <tbody>
                    @forelse($data->pembelian as $pembelian)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$pembelian->createdOn}}</td>
                        <td>{{$pembelian->qty}}</td>
                    </tr>

                    @php
                    $qty += $pembelian->qty;
                    @endphp
                    @empty
                    <tr>
                        <td>1</td>
                        <td>Tidak Ada Data</td>
                        <td>0</td>
                        @endforelse
                    </tr>
                </tbody>
            </table>
            Retur Pembelian:
            <table class="table table-bordered table-stripped">
                <thead>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Qty</th>
                </thead>
                <tbody>
                    @forelse($data->returpembelian as $returpembelian)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$returpembelian->createdOn}}</td>
                        <td>{{$returpembelian->qty}}</td>
                    </tr>
                    @php
                    $qty -= $returpembelian->qty;
                    @endphp
                    @empty
                    <tr>
                        <td>1</td>
                        <td>Tidak Ada Data</td>
                        <td>0</td>
                        @endforelse
                    </tr>
                </tbody>
            </table>
            Retur Penjualan:
            <table class="table table-bordered table-stripped">
                <thead>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Qty</th>
                </thead>
                <tbody>
                    @forelse($data->returpenjualan as $returpenjualan)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$returpenjualan->createdOn}}</td>
                        <td>{{$returpenjualan->qty}}</td>
                    </tr>

                    @php
                    $qty += $returpenjualan->qty;
                    @endphp
                    @empty
                    <tr>
                        <td>1</td>
                        <td>Tidak ada Data</td>
                        <td>0</td>
                        @endforelse
                    </tr>
                </tbody>
            </table>
            <div>
                Total : {{$qty}}
            </div>
        </section>
    </div>
</div>
@endsection

@push('js')
<script>
    swal.fire("Info stok pertanggal stok opname terakhir. Tanggal 8 Januari 2020");
</script>
@endpush