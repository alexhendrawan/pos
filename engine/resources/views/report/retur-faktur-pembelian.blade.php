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
	font-size: 90%;
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
	font-size: 16px;
	
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
<section class=" table-responsive">
	<htmlpageheader name="page-header">
		<h1 style="text-align: center; font-size: 20px;">Faktur Retur Pembelian</h1>
		<br>
		</htmlpageheader>
		<div class="col-md-12" style="display: inline; margin-top: 0px; margin-bottom: 0px;height: 60vh;">


			<table class="table table-bordered no-border" style="text-align:left;border: solid 2px black; ">
				<tr>
					<td style="width: auto;">No. Faktur</td>
					<td> {{$data->no_trans->internal_invoice_no}} || {{$data->no_trans->supplier_invoice_no}} || {{$data->debitmemo_id->supplier_header->no_invoice}}</td>
					<td class="tg-yw4l"></td>
					<td class="tg-yw4l"></td>
					<td></td>
					<td>Kepada Yth.</td>
				</tr>
			
				<tr>
					<td style="width: 100px;">Tanggal</td>
					<td> {{date("d-m-Y",strtotime($data->createdOn))}}</td>
					<td class="tg-yw4l"></td>
					<td class="tg-yw4l"></td>
					<td></td>
					<td>{{$data->debitmemo_id->supplier_header->supplier_code->supplier_name}}</td>
				</tr>
				<tr>
					<td class="tg-yw4l" style="width: 100px;"></td>
					<td class="tg-yw4l"></td>
					<td class="tg-yw4l"></td>
					<td class="tg-yw4l"></td>
					<td class="tg-yw4l"></td>
					<td>{{$data->debitmemo_id->supplier_header->supplier_code->supplier_address}} {{$data->debitmemo_id->supplier_header->supplier_code->phone_num}}</td>
				</tr>

				<tr>
					<td style="width: 100px;"></td>
					<td></td>
					<th class="tg-yw4l"></th>
					<td class="tg-yw4l"></td>

					<td></td>
					<td></td>
				</tr>

			</table>


			<table class="table table-bordered table-stripped data" style="border: solid 2px black;">
				<style type="text/css">
				th {
					font-weight: 800;
				}
			</style>
			<tr style="border: black 2px solid;">
				<td style="text-align: center">No</td>
				<td style="text-align: center">Nama Barang</td>
				<td colspan="2" style="text-align: center;" ><span style="padding-left:5px;">QTY</span></td>
				<td style="text-align: center">Harga</td>
				<td style="text-align: center;border:none">Total</td>
			</tr>
			@foreach($line as $key)
			<tr >
				<td style="width:40px;text-align: center;"><span style="text-align:center">{{$loop->iteration}}</span></td>

				<td style="width:600px">
					{{$key->item_stock_id->item->item_id->item_name}}
				</td>

				<td style="border:none; width:auto">
					<span style="float:right">{{$key->qty}}</span>
				</td>
				<td style="width:auto">
					<span style="">{{$key->item_stock_id->satuan_id->name}}</span>
				</td>

				<td style="width:auto;text-align: center">
					<span style="">{{number_format(($key->retur_price))}}</span>
				</td>
				<td style="width:200px; border:none; text-align: center">
					<span style="margin-right: 7px;">{{number_format($key->qty*$key->retur_price)}}</span>

				</td>
			</tr>
			@endforeach @for($i=count($line);$i
			<=15;$i++)
			<tr style="height: 24px; ">
				<td style="">
				</td>
				<td style="">

				</td>
				<td  style="border-right :none;">

				</td>
				<td style="" >

				</td>
				<td style="">
				</td>

				
				<td style="">
				</td>
			</tr>
			@endfor

			<tr style="height: 24px; ">
				<td style=" border-bottom:none">
				</td>
				<td style=" border-bottom:none">

				</td>
				<td style="border-right: none; border-bottom:none">

				</td>
				<td style=" border-bottom:none">
				</td>

				
				<td style="border-top: solid 2px black; border-bottom:none; border-right:none; font-weight:800">
					Total:  
				</td>
				<td  style="border-top: solid 2px black; border-bottom:none; font-weight:800; text-align:right">
					Rp. {{number_format($data->debitmemo_id->total)}}
				</td>
			</tr>
		</table>


		<div class="row">
			<div class="col-md-10 offset-1">
				<table>
					<tr>
						<td style="text-align:center">Penerima</td>
						<td></td>
						<td style="width:250px"></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr style="height:24px">
						<td> </td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr style="height:24px">
						<td> </td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr style="height:24px">
						<td> </td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td> Note: Penagihan harus disertai faktur asli</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				</table>



			</div>
		</div>

	</section>
	@include('report.footer')