  @extends("layouts.main")
  @section("title")
  Pembelian
  @endsection
  @section("content")
  <div class="page-content-wrapper">
      <div class="container-fluid">
       <form action="{{url('/')}}/po" method="post">
        @csrf
        <div class="form-group hide">
            Status:
            <select name="status" class="form-control hide">
                <option value="DR">Draft</option>
                <option selected value="C">Confirm</option>

            </select>
        </div>

        <div class="form-group">
            Supplier:
            <select name="supplier_id" class="supplier form-control" required=""></select>

        </div>

        <div class="form-group hide">
            Total Dibayar:
            <input autocomplete="off" value="0" type="hidden" maxlength="10" name="gt" class="form-control" required="">
        </div>

        <div class="form-group">
            Gudang:
            <select name="warehouse_id" class="warehouse form-control" required=""></select>
        </div>
        <div id="databarang">
            <input autocomplete="off" type="hidden" name="count" class="count" value="">
        </div>
        <div class="form-group">
            <input autocomplete="off" type="submit" onsubmit="check();" class="form-control btn btn-info dis" value="Create">
        </div>


        <!-- /.content -->


        <div class="row">
            <div class="box col-md-12">

                <div class="col-md-12 col-xs-12">

                    <div class="col-md-12" id="bbb" style="overflow-y: auto">
                        <table id="" class="table table-bordered table-stripped">
                            <thead>

                                <th>No</th>
                                <th>Barang</th>
                                <th>QTY Buy</th>
                                <th>Satuan</th>
                                <th>Void</th>

                            </thead>
                            <tbody id="myTable">

                            </tbody>
                        </table>

                    </div>
                    <div class="form-group">
                        Barang:
                        <select type="text" id="var3" class="inventory form-control"=""></select>

                    </div>

                    <div class="form-group">
                        QTY Beli:
                        <input autocomplete="off" type="text" id="var5" class="form-control"="">
                    </div>


                    <div class="form-group">
                        Satuan:
                        <select id="var7" class="form-control satuan">
                        </select>
                    </div>

                    <div class="form-group hide">
                        <input autocomplete="off" type="button" onclick="myFunction()" class="form-control btn btn-info dis" value="Tambah Barang">
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
@endsection

@push("js")
<script type="text/javascript">
    $('.supplier').select2({
        selectOnClose: true,
        placeholder: 'Pilih Supplier',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/supplier',
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.supplier_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });


    $('.inventory').select2({
        selectOnClose: true,
        placeholder: 'Pilih Barang',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/inventoryproperty',
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.item.item_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    $(".inventory").change(function () {
        $.ajax({
            url: "{!! url('/') !!}" + '/ajax/item_stock/inven/'+$(".inventory").val(), 
            method: "get",
            success: function (response) {
                var newOption = new Option(response["name"], response["id"], true, true);
                $('.satuan').append(newOption).trigger('change');
            },
            error: function (xhr, statusCode, error) {
            }
        });
    });

    $('.satuan').select2({
        selectOnClose: true,
        placeholder: 'Pilih Satuan',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/satuan',
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('.warehouse').select2({
        selectOnClose: true,
        placeholder: 'Pilih Gudang',
        ajax: {
            url: "{!! url('/') !!}" + '/ajax/gudang',
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.warehouse_name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>



<script>
    $(document).ready(function() {
      $(window).keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
      }
  });
  });

</script>

<script type="text/javascript">
    var count = 1;
    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            if($("#var5").val() !=0){
                var table = document.getElementById("myTable");
                var row = table.insertRow();
                row.setAttribute('id', 'row' + count);

                var cell1 = row.insertCell(0);
                var cell2 = row.insertCell(1);
                var cell3 = row.insertCell(2);
                var cell4 = row.insertCell(3);
                var cell6 = row.insertCell(4);


                cell1.innerHTML = count;
                cell2.innerHTML = $(".inventory option:selected").text();


                cell3.innerHTML = $("#var5").val();
                cell4.innerHTML = $("#var7 :selected").text();
                cell6.innerHTML = '<button type="button" onclick="voidbarang(' + count + ')">Void</button>';

                var container = document.getElementById("databarang");

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "data-item-id-" + count;
                input.setAttribute('value', $(".inventory").val());
                input.setAttribute('id', "data-item-id-" + count);
                container.appendChild(input);



                container.appendChild(input);

                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "data-qty-id-" + count;
                input.setAttribute('value', $("#var5").val());
                input.setAttribute('id', "data-qty-id-" + count);

                container.appendChild(input);
                var input = document.createElement("input");
                input.type = "hidden";
                input.name = "data-unit-id-" + count;
                input.setAttribute('id', "data-unit-id-" + count);
                input.setAttribute('value', $("#var7").val());
                container.appendChild(input);

                $(".count").val(count);

                count++;

                var objDiv = document.getElementById("bbb");
                objDiv.scrollTop = objDiv.scrollHeight;

                $("#var3").val("null").trigger('change');
                $("#var4").val("null").trigger('change');
                $("#var5").val("0");
                $("#var7").val("null").trigger('change');
                $(".inventory").select2("open");

            }
        }

    });

    function myFunction() {

        var table = document.getElementById("myTable");
        var row = table.insertRow();
        row.setAttribute('id', 'row' + count);

        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);
        var cell4 = row.insertCell(3);
        var cell6 = row.insertCell(4);


        cell1.innerHTML = count;
        cell2.innerHTML = $(".inventory option:selected").text();


        cell3.innerHTML = $("#var5").val();
        cell4.innerHTML = $("#var7 :selected").text();
        cell6.innerHTML = '<button type="button" onclick="voidbarang(' + count + ')">Void</button>';

        var container = document.getElementById("databarang");

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "data-item-id-" + count;
        input.setAttribute('value', $(".inventory").val());
        input.setAttribute('id', "data-item-id-" + count);
        container.appendChild(input);



        container.appendChild(input);

        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "data-qty-id-" + count;
        input.setAttribute('value', $("#var5").val());
        input.setAttribute('id', "data-qty-id-" + count);

        container.appendChild(input);
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "data-unit-id-" + count;
        input.setAttribute('id', "data-unit-id-" + count);
        input.setAttribute('value', $("#var7").val());
        container.appendChild(input);

        $(".count").val(count);

        count++;

        var objDiv = document.getElementById("bbb");
        objDiv.scrollTop = objDiv.scrollHeight;

        $("#var3").val("null").trigger('change');
        $("#var4").val("null").trigger('change');
        $("#var5").val("0");
        $("#var7").val("null").trigger('change');
    }

</script>

<script type="text/javascript">
    function voidbarang(count) {
        $("#data-unit-id-" + count).remove();
        $("#data-qtyget-id-" + count).remove();
        $("#data-qty-id-" + count).remove();
        $("#data-warna-id-" + count).remove();
        $("#data-item-id-" + count).remove();
        $("#data-unit-id-" + count).remove();
        $("#row" + count).remove();
        count--;
    }

</script>
@endpush