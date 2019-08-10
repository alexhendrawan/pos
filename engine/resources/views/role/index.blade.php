  @extends("layouts.main")
  @section("title")
  Role
  @endsection
  @section("content")
  <div class="page-content-wrapper">
    <div class="container-fluid">
      <section class=" table-responsive">
        <table id="tabel" class="table table-bordered table-hover box">
          <thead>
            <th class="col-head" >
              No

            </th>

            <th class="col-head" >
              Nama

            </th>

            <th class="col-head" >

            </th>
          </thead>
          <tbody id="item-table">
            @foreach($data as $key)<tr>
              <td class="">{{$loop->iteration}}</td>

              <td>{{$key->name}}</td>

              <td>  
                <div id="menutable">
                  <a href="<?php echo url("/") ?>/role/{{$key->id}}" class="btn btn-warning dis" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                  <button class="btn btn-danger dis" onclick="konfirmasi({{$key->id}},'role')"><i class="fas fa-trash" aria-hidden="true"></i></button>
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