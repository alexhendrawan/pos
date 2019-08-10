@extends("layouts.main")
@section("title")
Edit Piutang
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="col-md-12 box">
            <div class="col-md-12">
                <h6>note: Jika Salah memilih invoice/faktur, data pelunasan dihapus saja, nanti sistem otomatis mengkoreksi data</h6>
                <form action="{{url('/')}}/piutang/{{ $data->id }}" method="post">

                    @csrf
                    @method("PUT")

                    <div class="form-group">
                        Nilai Pembayaran:
                        <input autocomplete="off" type="text" id="pembayaran" name="payment_value" class="form-control"
                        required="" value="{{ $data->payment_value }}">
                    </div>

                    <div class="form-group">
                        Note:
                        <textarea id="var5" class="form-control" name="note">{{ $data->note }}</textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <input autocomplete="off" type="submit" class="form-control btn btn-info dis" value="Ubah">
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
            delay: 600,
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