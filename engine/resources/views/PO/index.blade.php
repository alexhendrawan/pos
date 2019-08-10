@extends("layouts.main")
@section("title")
Pembelian
@endsection
@section("content")
<div class="page-content-wrapper">
	<div class="container-fluid">
		<div class="row float-right">
			<a href="{{ url('po?riwayat=cl') }}" class="btn btn-info">Lunas</a>
			<a href="{{ url('po?riwayat=c') }}" class="btn btn-success">Belum Lunas</a>
		</div>
		<section class=" table-responsive">
			<table id="tabel" class="table table-bordered table-hover box">
				<thead>
					<th class="col-head">
						No

					</th>

					<th class="col-head">
						NO PO

					</th>

					<th class="col-head">
						Nama Supplier

					</th>
					<th class="col-head">
						Total

					</th>
					<th class="col-head">
						Total Dibayar
					</th>
					<th class="col-head">
						Gudang
					</th>

					<th>
						Operator
					</th>

					<th>
						Action
					</th>


				</thead>
				<tbody id="item-table">
					@foreach($data as $key)
					<tr class="">
						<td onclick="detailpo({{$key->id}})" class="">{{$loop->iteration}}</td>
						<td onclick="detailpo({{$key->id}})">{{$key->po_no}}</td>
						<td onclick="detailpo({{$key->id}})">{{$key->supplier->supplier_name}}</td>
						<td onclick="detailpo({{$key->id}})" class="printUang">{{$key->po_total}}</td>
						<td onclick="detailpo({{$key->id}})" class="printUang">{{$key->po_total_paid}}</td>
						<td onclick="detailpo({{$key->id}})">{{$key->warehouse->warehouse_name}}</td>
						<td onclick="detailpo({{$key->id}})">{{$key->createdBy}}</td>
						<td>
							<div id="menutable">
								<a href="<?php echo url("/") ?>/po_header/detail/{{$key->id}}"
									class="btn btn-xs btn-success dis" style="width: 100%">Edit</a>
								<a href="<?php echo url("/") ?>/penerimaan/{{$key->id}}/create"
									class="btn btn-xs btn-warning dis" style="width: 100%">Penerimaan</a>
								<button class="btn btn-xs btn-danger dis" onclick="konfirmasi({{$key->id}},'po')"
									style="width: 100%">Delete</button>
								<button onclick="printfaktur({{$key->id}},'print/faktur/po')"
									class="btn btn-xs btn-info" style="width: 100%">Print Faktur</button>
							</div>
						</td>

					</tr>
					@endforeach

				</tbody>
			</table>
		</section>
	</div>
</div>
@endsection

@push("js")
<script type="text/javascript">
	function detailpo (id){
    window.location = "{!!url('po')!!}/detail/" + id;
  }
</script>
@endpush
