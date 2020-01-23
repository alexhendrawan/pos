@include('report.header')
<style type="text/css">
    html,
    body,
    div,
    span,
    applet,
    object,
    iframe,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    blockquote,
    pre,
    a,
    abbr,
    acronym,
    address,
    big,
    cite,
    code,
    del,
    dfn,
    em,
    img,
    ins,
    kbd,
    q,
    s,
    samp,
    small,
    strike,
    strong,
    sub,
    sup,
    tt,
    var,
    b,
    u,
    i,
    center,
    dl,
    dt,
    dd,
    ol,
    ul,
    li,
    fieldset,
    form,
    label,
    legend,
    table,
    caption,
    tbody,
    tfoot,
    thead,
    tr,
    th,
    td,
    article,
    aside,
    canvas,
    details,
    embed,
    figure,
    figcaption,
    footer,
    header,
    hgroup,
    menu,
    nav,
    output,
    ruby,
    section,
    summary,
    time,
    mark,
    audio,
    video {
        margin: 0;
        padding: 0;
        border: 0;
        font-size: 100%;
        font: inherit;
        vertical-align: baseline;
        height: auto;
        width: auto;
    }

    /* HTML5 display-role reset for older browsers */

    article,
    aside,
    details,
    figcaption,
    figure,
    footer,
    header,
    hgroup,
    menu,
    nav,
    section {
        display: block;
    }

    body {
        line-height: 1;
        
    }

    ol,
    ul {
        list-style: none;
    }

    blockquote,
    q {
        quotes: none;
    }

    blockquote:before,
    blockquote:after,
    q:before,
    q:after {
        content: '';
        content: none;
    }

    table {
         border-collapse: collapse;
        padding: 0px !important;
    }

    body,
    h4 {
        font-family: arial;
        font-size: 17px;
    
    }

    .table td, .table th {
        padding: 0.25rem;
        border: none;

    }
    
    .table.data td{
        border-right: solid 2px black
    }
    
    .table.data 
    tr{
         border-collapse: separate;
    border-spacing: 10px;
    }
    

    .table.no-border tr {
        border: none;
    }
</style>
<section class="">
    <htmlpageheader name="page-header">
        <h1 style="text-align: center; font-size: 20px;">Faktur Penjualan</h1>
        <br>
    </htmlpageheader>

    <div class="col-md-12" style="display: inline; margin-top: 0px; margin-bottom: 0px;height: 60vh;">



         <table class="table table-bordered no-border" style="text-align:left;border: solid 2px black; ">

            <tr>
                <td style="width: 100px;">No. Faktur</td>
                <td> {{$data->po_no}}</td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td></td>
                <td>Kepada Yth.</td>
            </tr>

            <tr>
                <td style="width: 100px;">Tanggal</td>
                <td> {{$data->createdOn}}</td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td></td>
                <td>{{$data->supplier->supplier_name}}</td>
            </tr>
            <tr>
                <td class="tg-yw4l" style="width: 100px;"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td class="tg-yw4l"></td>
                <td>{{$data->supplier->supplier_address}}</td>
            </tr>



        </table>


          <table class="table table-bordered table-stripped" style="border: solid 2px black;">
            <style type="text/css">
                th {
                    font-weight: 800;
                }
            </style>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>QTY</th>
                <th>Satuan</th>

            </tr>
            @foreach($line as $key)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>
                    {{$key->inventoryproperty->item->item_name}}
                </td>
                <td>
                    {{$key->qty_buy}}
                </td>
                <td>
                    {{$key->satuan->name}}
                </td>

            </tr>
            @endforeach @for($i=count($line);$i
            <=16;$i++) <tr style="height: 11px; border: 1px solid black">
                <td></td>
                <td>

                </td>
                <td>

                </td>
                <td>

                </td>
                <td>


                </td>
                <td>


                </td>
                </tr>
                @endfor
        </table>


        <div class="row">
        <div class="col-md-5 offset-1">
            <table>
            <tr>
            <td style="text-align:center">Penerima</td>
            <td></td>
            <td style="width:500px"></td>
            <td></td>
            <td></td>
            <td></td>
    
            </table>
            </div>
            <div class="col-md-10 offset-1" style="margin-top: 7%">
                Note: Penagihan harus disertai faktur asli
            </div>
    </div>

</section>
    @include('report.footer')