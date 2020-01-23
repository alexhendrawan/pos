      @extends("layouts.main")
      @section("title")
      Pembayaran Hutang
      @endsection
      @section("content")
      <div class="page-content-wrapper">
          <div class="container-fluid">
             <table id="tabel" class="table table2excel table-bordered table-hover box">
                <thead>
                    <th class="col-head" >
                        No
                    </th>
                    <th class="col-head" >
                        Supplier
                    </th>
                    <th class="col-head" >
                        No Invoice
                    </th>
                    <th class="col-head" >
                        Tanggal
                    </th>
                    <th class="col-head" >
                        Pembayaran
                    </th>
                    <th class="col-head" >
                        Status
                    </th>
                    <th class="col-head" >
                        Besar
                    </th>
                    <th class="col-head" >
                        Notes
                    </th>
                    <th>
                        Operator
                    </th>
                    <th class="col-head" >
                        Pencairan
                    </th>
                    <th class="col-head" >
                        Action
                    </th>
                </thead>
                <tbody id="item-table"> <?php $i = 1; ?>
                    @foreach($data as $key)<tr>
                        <td>{{$i++}}</td>
                        <td>{{$key->purchaseinvoiceheader->poheader->supplier->supplier_name ?? ""}}</td>
                        <td>{{$key->purchaseinvoiceheader->internal_invoice_no ?? ""}}</td>
                        <td>{{date("d-m-Y", strtotime($key->createdOn))}}</td>
                        <td>@if($key->payment_id=="C")
                            Cash
                            @elseif($key->payment_id=="G")
                            Giro
                            @elseif($key->payment_id=="CH")
                            Cek
                            @elseif($key->payment_id=="TR")
                            Transfer
                            @endif
                        </td>
                        <td>{{$key->invoice_payment_status}}</td>
                        <td class="printUang">{{$key->payment_value}}</td>
                        @php
                        $notes="";
                        if(isset($key->note)){
                            $notes = explode("||",$key->note);
                        }
                        @endphp
                        <td>{{$notes[0] ?? null}}</td>
                        <td>{{$key->createdBy}}</td>
                        <td>
                            -
                        {{-- @if(($key->payment_id=="G" || $key->payment_id=="CH") && count($notes) == 1)
                        <a href="{{url('/')}}/pencairanpayment/{{$key->id}}" class="btn btn-success">Pencairan</a>
                        @else
                        <a href="#" disabled class="btn btn-black">Pencairan</a>
                        @endif --}}
                    </td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-outline-dark dropdown-toggle btn-sm" type="button"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ url("hutang/$key->id") }}" class="dis" ><i class="fas fa-dollar-sign"></i>Pembayaran</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" onclick="konfirmasi({{$key->id}},'hutang')" class="dis"><i class="fas fa-trash" aria-hidden="true"></i>Hapus</a>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
</div>
</div>
@endsection