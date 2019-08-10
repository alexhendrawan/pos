@include('report.header')
{{dd($payment)}}

<style type="text/css">
body, h4{
	font-family: "Times New Roman", Times, serif !important;
	font-weight: 800;
	font-size: 12px;
}
</style>
<section class=" table-responsive">
	<htmlpageheader name="page-header">
		<h4 style="text-align: center">Faktur Penjualan</h4>
		</htmlpageheader>


		<div class="col-md-12" style="display: inline; margin-top: 0px; margin-bottom: 0px;>

			<table class="table table-stripped" style="text-align:left">

				<tr>
					<td>No. Faktur	:	{{$data->intnomorsales}}</td>
					<td>	</td>
					<th class="tg-yw4l"></th>
					<td></td>
					<td>Kepada Yth.</td>
				</tr>
				<tr>
					<td>Tanggal	: {{$data->createdOn}}</td>
					<td></td>
					<td class="tg-yw4l"></td>
					<td></td>
					<td>{{$data->customer_id->name}}</td>
				</tr>
				<tr>
					<td class="tg-yw4l">Sales	: {{$data->customer_id->sales->displayName ?? $data->customer_id->sales->username}}	</td>
					<td class="tg-yw4l"></td>
					<td class="tg-yw4l"></td>
					<td class="tg-yw4l"></td>
					<td>{{$data->customer_id->customer_address}}</td>
				</tr>

				<tr>
					<td>Supir	:	{{$shipment->staff1->username}}</td>
					<td>	</td>
					<th class="tg-yw4l"></th>
					<td></td>
					<td>Kenek  :	{{$shipment->staff2->username}}</td>
				</tr>
				
			</table>

			<table class="table table-bordered table-stripped">
				<tr>
					<td>No</td>
					<td>Nama Barang</td>
					<td>QTY</td>
					<td>Harga</td>
					<td>Diskon</td>
					<td>Total</td>
				</tr>
				@foreach($line as $key)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>
						{{$key->item_stock_id->item->brand_id->name}} {{$key->item_stock_id->item->item_color_id->name}} {{$key->item_stock_id->item->item_id->item_name}}
					</td>
					<td>
						{{$key->qty}}
					</td>
					<td>
						Rp. {{number_format(($key->price_per_Satuan_id))}}
					</td>
					<td>
						Rp. {{number_format(($key->qty*$key->item_stock_id->sell_price)-($key->qty*$key->price_per_Satuan_id) ) }}

					</td>
					<td>
						Rp. {{number_format($key->qty*$key->price_per_Satuan_id)}}

					</td>
				</tr>
				@endforeach
			</table>

		</div>
		<htmlpagefooter name="page-footer">
			<table class="table">
				<tr>
					<td>
						Penerima,
					</td>
					<td>

					</td>
					<td>

					</td>
					<td>
						Total Faktur:
					</td>
					<td class="printUang">
						Rp. {{number_format($data->total_sales)}}
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;

					</td>
					<td>
						&nbsp;

					</td>
					<td>
						&nbsp;

					</td>
					<td class="printUang">

					</td>
				</tr>
				<tr>
					<td>

					</td>
					<td>

					</td>
					<td>

					</td>
					<td>

					</td>
					<td class="printUang">

					</td>
				</tr>
				<tr>
					<td>
						.............................<br>
						Note: Penagihan harus disertai faktur asli
					</td>
					<td>

					</td>
					<td>

					</td>
					<td>

					</td>
					<td class="printUang">
						Jatuh Tempo: {{$data->due_date}}
					</td>
				</tr>

			</table>
			</htmlpagefooter>
		</section>

		@include('report.footer')
