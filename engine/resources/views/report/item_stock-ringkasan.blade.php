
@include('report.header')
<div style="display: inline-flex;">
	<table class="table ">
		<tr>
			@if(isset($category))
			<td>Kategori: {{$category}}</td>
			@endif
			@if(isset($merk))
			<td>Merk: {{$merk}}</td>
			@endif
			@if(isset($suppliernames))
			<td>Supplier: {{$suppliernames}}</td>
			@endif
			@if(isset($customernames))
			<td>Konsumen: {{$customernames}}</td>
			@endif
		</tr>
	</table>
</div>
<section class=" table-responsive">
	<table id="tabel" class="table table-bordered table-hover box">
		<tr>
			<td>No</td>


			<td>Nama Barang</td>

			<td>Satuan</td>

			<td>Sisa Stok</td>
			@if(Session()->get("user")->role_id==1 && $hargabeli == "on") 
			<td>Harga Beli</td>           
			@endif
			
			@if( $hargajual == "on") 
			<td>Harga Jual</td>
			@endif
			

			<td>Gudang</td>
		</tr>
		{{-- {{dd($data)}} --}}
		@foreach($data as $key)
		<tr>
			<td class="">{{$loop->iteration}}</td>
			<td>{{$key->item_name ?? null}}</td>
			<td>{{$key->satuanname ?? $key->name}}</td>
			<td class="">{{$key->qty ?? null}}</td>
			@if(Session()->get("user")->role_id==1 && $hargabeli == "on") 
			<td class="printUang">{{$key->purchase_price ?? null}}</td>                    
			@endif
			@if( $hargajual == "on") 
			<td class="printUang">{{$key->sell_price ?? null}}</td>
			@endif		     
			<td>{{$key->warehouse_name ?? null}}</td>
		</tr>

		@endforeach
	</table>
</section><!-- /.content -->
@include('report.footer')