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
		font-size: 18px;
	
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



		<table class="table no-border" style="text-align:left; ">

			<tr>
				<td style="width: 100px;">No. Faktur</td>
				<td> {{$data->intnomorsales}}</td>
				<td class="tg-yw4l"></td>
				<td class="tg-yw4l"></td>
				<td></td>
				<td>Kepada Yth.</td>
			</tr>

			<tr>
				<td style="width: 100px;">Tanggal</td>
				<td> {{date("d-m-Y",strtotime($data->order_date))}}</td>
				<td class="tg-yw4l"></td>
				<td class="tg-yw4l"></td>
				<td></td>
				<td>{{$data->customer->name}}</td>
			</tr>
			<tr>
				<td class="tg-yw4l" style="width: 100px;">Sales</td>
				<td class="tg-yw4l">{{$data->customer->sales->displayName ?? $data->customer->sales->username}}</td>
				<td class="tg-yw4l"></td>
				<td class="tg-yw4l"></td>
				<td class="tg-yw4l"></td>
				<td>{{$data->customer->customer_address}}</td>
			</tr>

			<tr>
				<td style="width: 100px;">Supir/Kenek</td>
					<td>{{$supir->displayName ?? null}}/{{$kenek->displayName ?? null}}</td>
				<td class="tg-yw4l"></td>
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
				<td style="text-align: center">Dis</td>
				<td style="text-align: center;border:none">Total</td>
			</tr>
			@foreach($line as $key)
		<tr >
				<td style="width:40px;text-align: center;"><span style="text-align:center">{{$loop->iteration}}</span></td>
				@if($key->price_per_satuan_id == 0)
				<td style="width:600px">
					{{$key->stock->inventoryproperty->item->item_name}} (Bonus)
				</td>
				@else
				<td style="width:600px">
					{{$key->stock->inventoryproperty->item->item_name}}
				</td>
				@endif
				<td style="border:none; width:auto">
					<span style="float:right">{{$key->qty}}</span>
				</td>
					<td style="width:auto">
					<span style="">{{$key->stock->satuan->name}}</span>
				</td>
			
				<td style="width:auto">
					<span style="float:right">{{number_format(($key->price_per_satuan_id))}}</span>
				</td>
				<td style="width:auto">
					<span style="float:right">0</span>

				</td>
				<td style="width:200px; border:none">
					<span style="float:right;margin-right: 7px;">{{number_format($key->qty*($key->price_per_satuan_id))}}</span>

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
				<td style="border-top: solid 2px black; border-bottom:none; border-right:none; font-weight:800">
				</td>
			<td  style="border-top: solid 2px black; border-bottom:none; font-weight:800; text-align:right">
 Rp. {{number_format($data->total_sales)}}
				</td>
				</tr>
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
			<td>Jatuh Tempo {{date("d-m-Y",strtotime($data->due_date))}}</td>
	
			</table>
			</div>
			<div class="col-md-10 offset-1" style="margin-top: 7%">
				Note: Penagihan harus disertai faktur asli
			</div>
	</div>

</section>
	@include('report.footer')