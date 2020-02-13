@extends("layouts.main")
@section("title")
Stok Sync
@endsection
@section("content")
<div class="page-content-wrapper">
    <div class="container-fluid">
          <table class="table table-bordered table-stripped">
                <thead>
                    <th>No</th>
                    <th>Nama Stock</th>
                    <th>Qty Saat Ini</th>
                    <th>Qty Hitung Manual</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($array as $key)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$key->inventoryproperty->item->item_name ?? "-"}}</td>
                        <td>{{$key->qty}}</td>
                        <td>{{$key->detail}}</td>
                        <td><a href="{{url('stok/'.$key->id)}}">Detail</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


    </div>
</div>
<div class="form-group col-md-4">
    <p>Melaksanakan update stok dengan acuan hitung manual (Terakhir stok opname / edit stok dikurangi transaksi yang terjadi)</p>
   <form action="{{url('stock/sync')}}" method="post">
       @csrf
       <input type="submit" class="btn btn-danger" name="" value="Apply!">
   </form>
</div>
</form>
</div>
@endsection
