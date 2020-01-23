@extends("layouts.main")
@section("title")
Pembayaran Hutang
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <form action="{{url("hutang")}}" method="post">
            @csrf
            <div class="form-group hide">
                Status:
                <select id="var7" name="invoice_payment_status" class="form-control ">
                    <option value="DR">Draft</option>
                    <option selected value="C">Confirm</option>
                </select>
            </div>
            <div class="form-group">
                Nomor Purchase Invoice<br>
                <select autocomplete="off" type="text" id="var2" name="purchase_invoice_header_id"
                    class="purchaseinv form-control" required="">
                    <option></option>
                    @foreach($data as $key)
                    @if($key->poheader != null)
                    <option value="{{ $key->id }}">{{ $key->poheader->supplier->supplier_name }}-
                        {{ $key->internal_invoice_no }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            {{-- <div class="form-group hide">
                Nomor Faktur:
                <input autocomplete="off" type="text" id="var1" name="purchase_invoice_no" class="form-control"
                    required="">
            </div> --}}
            <div class="form-group">
                Cara Pembayaran:
                <select id="var6" name="payment_id" class="form-control" onchange="changePembayaran(this.value)">
                    <option value="C">Cash</option>
                    {{-- <option value="TR">Transfer</option> --}}
                    {{-- <option value="G">Giro</option> --}}
                    {{-- <option value="CH">Check</option> --}}
                </select>
            </div>

            <input name="bank_id" value="1" type="hidden">
            <div class="form-group">
                Nilai Pembayaran:
                <input autocomplete="off" type="text" id="nilaipembayaran" name="payment_value" class="form-control"
                    required="">
            </div>
            <input autocomplete="off" id="var5" type="hidden" class="form-control" name="note" value="-">
            <div class="form-group">
                Note:
                <textarea id="var5" class="form-control" name="note"></textarea>
            </div>

            <div class="form-group col-md-4">
                <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Create">
            </div>
        </form>
    </div>
</div>
@endsection

@push("js")
<script type="text/javascript">
    $(".purchaseinv").select2({
        placeholder:"No Inv"
    })


    $(".purchaseinv").change(function(){
        var id = $(".purchaseinv").val();
        $.ajax({
            url: "{{url('/')}}"+"/ajax/" + "purchase_invoice/" + id ,
            method: "get",
            success: function (response) {
                var total = parseInt(response.invoice_total);
                var paid = parseInt(response.paid_total);
                console.log(total);
                console.log(paid);
                $("#nilaipembayaran").val(total-paid);
            },
            error: function (xhr, statusCode, error) {

            }
        });   
    })
</script>
@endpush