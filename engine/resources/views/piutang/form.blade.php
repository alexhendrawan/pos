@extends("layouts.main")
@section("title")
Piutang
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12 box">
            <div class="col-md-4 col-xs-12">
                <form action="{{url('/')}}/piutang" method="post">
                    {{csrf_field()}}

                    <div class="form-group d-none">
                        Status:
                        <select id="var7" name="status" class="form-control">
                            <option value="DR">Draft</option>
                            <option selected="" value="C">Confirm</option>

                        </select>
                    </div>
                    <div class="form-group">
                        Nomor Sales
                        <!-- <input autocomplete="off" type="text"  name="poid" class="form-control" required=""> -->
                        <select type="text" id="var2" name="sales" class="sales form-control" required=""></select>
                    </div>
                    <div class="d-none form-group">
                        Sales DP
                        <!-- <input autocomplete="off" type="text"  name="poid" class="form-control" required=""> -->
                        <select type="text" id="var2" name="salesdp" class="salesdp form-control">

                        </select>
                    </div>
                    {{-- <div class="d-none form-group">
                        Nomor Faktur:
                        <input autocomplete="off" type="text" id="var1" name="nomorfaktur" class="form-control"
                            required="">
                        <!-- <select type="text"  id="var2" name="nopo" class="poheader form-control" required=""></select> -->
                    </div> --}}
                    <div class="form-group">
                        Cara Pembayaran:
                        <select id="var6" name="payment_id" class="form-control"
                            onchange="changePembayaran(this.value)">
                            <option selected value="C">Cash</option>
                            <option value="TR">Transfer</option>
                            <option value="G">Giro</option>
                            <option value="CH">Check</option>
                        </select>
                    </div>
                    <div class="form-group" id="nomorgiro" style="display: none;">
                        <span id="textNomorGiro">Nomor Giro:</span>
                        <input autocomplete="off" type="text" id="var3" name="giro" class="form-control">
                    </div>

                    <div class="form-group d-none">
                        Bank:
                        <select name="bank" class="form-control bankcash" required>
                            <option value="1" selected>Bank</option>
                        </select>
                    </div>


                    <div class="form-group" id="jatuhtempo" style="display: none;">
                        <span id="textJatuhTempo">Jatuh Tempo Giro:</span>
                        <input autocomplete="off" type="date" id="var9" name="jatuhtempo" class="form-control">
                    </div>

                    <div class="form-group" id="girocair" style="display: none;">
                        <span id="textGiroCair">Giro Cair:</span>
                        <input autocomplete="off" type="checkbox" id="var10" class="" name="girocair">
                    </div>
                    <div class="form-group">
                        Nilai Pembayaran:
                        <input autocomplete="off" type="text" id="pembayaran" name="nilaibayar" class="form-control"
                            required="">
                    </div>
                    <div class="form-group">
                        Nilai Diskon (%):
                        <input autocomplete="off" type="text" name="diskon" id="diskonsales" class="form-control"
                            value="0">
                    </div>
                    <div class="form-group">
                        Note:
                        <textarea id="var5" class="form-control" name="note">-</textarea>
                    </div>




                    <div class="form-group col-md-4">
                        <!-- <input autocomplete="off" type="button" onclick="createpo_dp()" class="form-control btn btn-info dis" value="Create"> -->
                        <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push("js")
<script type="text/javascript">
    $('.sales').select2({
        selectOnClose: true,
        placeholder: 'Pilih Sales',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/sales/hutang',
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: $.map(data.data, function (item) {
                        return {
                            text: item.customer.name + " " + item.intnomorsales,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $(".sales").change(function(){
     $.ajax({
        url: "{!! url('/') !!}" + '/ajax/sales/'+ $(".sales").val(),
        method: "get",
        success: function (response) {
            $("#pembayaran").val(response["payment_remain"]);
            grandsales = response["payment_remain"];
        },
        error: function (xhr, statusCode, error) {
        }
    });
 })
    function changePembayaran(selectedValue) {
        var jatuhtempo = document.getElementById("jatuhtempo");
        var girocair = document.getElementById("girocair");
        var nomorgiro = document.getElementById("nomorgiro");

        var textjatuhtempo = document.getElementById("textJatuhTempo");
        var textgirocair = document.getElementById("textGiroCair");
        var textnomorgiro = document.getElementById("textNomorGiro");

        if (selectedValue == "G") {//giro
            jatuhtempo.style.display = "block";
            girocair.style.display = "block";
            nomorgiro.style.display = "block";
            textjatuhtempo.innerHTML = "Jatuh Tempo Giro";
            textgirocair.innerHTML = "Giro Cair";
            textnomorgiro.innerHTML = "Nomor Giro";
        } else if (selectedValue == "CH") {//check
            jatuhtempo.style.display = "block";
            girocair.style.display = "block";
            nomorgiro.style.display = "block";
            textjatuhtempo.innerHTML = "Jatuh Tempo Check";
            textgirocair.innerHTML = "Check Cair";
            textnomorgiro.innerHTML = "Nomor Check";
        } else if (selectedValue == "C" || selectedValue == "TR") {//cash ?? trf
            jatuhtempo.style.display = "none";
            girocair.style.display = "none";
            nomorgiro.style.display = "none";
        }
    }
</script>
@endpush