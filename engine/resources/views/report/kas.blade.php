@include('report.header')

<section class=" table-responsive">
    <htmlpageheader name="page-header">
    <h4>Laporan Kas Per Tanggal {{date("d-m-Y")}}</h4>

    </htmlpageheader>


  <!-- Main content -->
  <section class=" table-responsive">
    <h4>Laporan Kas</h4>
   <table id="tabel" class="table table-bordered table-hover box">
            <thead>
            <th class="col-head" >
                No

            </th>

            <th class="col-head" >
                Transaction No

            </th>
            <th class="col-head" >
                Bank Cash

            </th>
            <th class="col-head" >
                Debit

            </th>
            <th class="col-head" >
                Credit

            </th>
            <th class="col-head" >
                Balance

            </th>
            <th class="col-head" >
                Note

            </th>



            </thead>
            <tbody id="item-table"> 
                <?php $i = 1; ?>
                @foreach($data as $key)<tr>
                    <td class="">{{$i++}}</td>
                    <td>{{$key->transaction_no}}</td>
                    <td>{{$key->bank_cash_id->account_name}}</td>
                    <td class="printUang">{{$key->debit}}</td>
                    <td class="printUang">{{$key->credit}}</td>
                    <td class="printUang">{{$key->balance}}</td>
                    <td>{{$key->note}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </section><!-- /.content -->
  </div><!-- /.content-wrapper -->


<!-- Footer -->
@include('report.footer')
