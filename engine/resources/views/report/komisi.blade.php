@include('report.header')
<style>
</style>
<section class=" table-responsive">
	<htmlpageheader name="page-header">
		<h4>Laporan Komisi Per Tanggal {{date("d-m-Y",strtotime($start)) ." - ". date("d-m-Y",strtotime($end))}}</h4>

		@if(isset($data->name))
		Konsumen : <h5>{{$data->name ?? null}}</h5>
		@endif
		@if(isset($data->displayName))
		Sales : <h5>{{$namasales->displayName ?? null}}</h5>
		@endif
		@if(isset($data[0]->item_name))
		Barang:<h5>{{$data[0]->item_name ?? null}}</h5>
		@endif
	</htmlpageheader>

	<htmlpagefooter name="page-footer">
	</htmlpagefooter>
	<table id="tabel" class="table-sm table-stripped table-bordered  table-hover box">
		<thead>
			<tr>
				<td style="width:auto" class="col-head">
					No
				</td>
				<td class="col-head">
					Tanggal Order
				</td>
				<td class="col-head">
					No Faktur
				</td>
				<td class="col-head">
					Konsumen
				</td>
				<td class="col-head">
					Gross Sale
				</td>
				<td class="col-head">
					Diskon
				</td>
				<td class="col-head">
					Retur
				</td>
				<td class="col-head">
					Netto
				</td>
				<td class="col-head">
					Total Bayar
				</td>
				<td class="col-head">
					Sisa Bayar
				</td>


				<td class="col-head">
					Komisi
				</td>




			</tr>

		</thead>
		{{ dd($data) }}
		<tbody id="item-table">

			@php
			$remain = 0;
			$paid = 0;
			$sales = 0;
			$diskon = 0;
			$retur = 0;
			$komisi = 0;
			$omzet = 0;
			$modal = 0;
			@endphp
			@foreach($data as $key)
			@php
			$remain +=$key->payment_remain;
			$paid +=$key->total_paid;
			$sales +=$key->total_sales;
			$diskon +=$key->diskon;
			$retur +=$key->retur;
			$omzet +=$key->total_sales - $key->modal;
			$modal +=$key->modal;
			$komisiiterate = 0;
			if($lihatsemuakomisi =="On"){

			$komisi +=$key->total_sales * 0.008;
			$komisiiterate =$key->total_sales * 0.008;

			}else{
			if($key->payment_remain == 0){

			$komisi +=$key->total_sales * 0.008;
			$komisiiterate =$key->total_sales * 0.008;

			}
			}
			@endphp
			<tr onclick="()">
				<td class="">{{$loop->iteration}}</td>
				<td>{{date("d-m-Y",strtotime($key->createdOn))}}</td>
				<td>{{$key->intnomorsales}}</td>
				<td>{{$data->name}}</td>
				<td class="printAngka">{{$key->total_sales + $key->diskon + $key->retur}}</td>
				<td class="printAngka">{{$key->diskon}}</td>
				<td class="printAngka">{{$key->retur}}</td>
				<td class="printAngka">{{$key->total_sales}}</td>
				<td class="printAngka">{{$key->total_paid}}</td>
				<td class="printAngka">{{$key->payment_remain}}</td>
				<td class="printAngka">{{$komisiiterate}}</td>




			</tr>
			@endforeach

			<tr onclick="()">
				<td class=""></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					Total Sales
				</td>
				<td>
					Total Diskon
				</td>
				<td class="col-head">
					Total Retur
				</td>
				<td class="col-head">
					Total Netto
				</td>
				<td class="col-head">
					Total Bayar
				</td>
				<td class="col-head">
					Sisa Bayar
				</td>

				<td class="col-head">
					Total Komisi
				</td>



			</tr>
			<tr onclick="()">
				<td class=""></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="printAngka" style="width: auto">{{$sales + $diskon + $retur}}</td>
				<td class="printAngka">{{$diskon}}</td>
				<td class="printAngka">{{$retur}}</td>
				<td class="printAngka">{{$sales}}</td>
				<td class="printAngka">{{$paid}}</td>
				<td class="printAngka">{{$remain}}</td>
				<td class="printAngka">{{$komisi}}</td>
			</tr>
		</tbody>
	</table>
</section><!-- /.content -->
@include('report.footer')