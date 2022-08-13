@extends('layouts.app')
@section('content')
<div class="container">

<div>
    <h2>Payment List</h2>
</div>
    <table class="table table-bordered table-hover" id="laravel_datatable">
        <thead>
            <tr>
                <th>Id</th>
                <th>Booking Id</th>
                <th>Payment Id</th>
                <th>Payment Status</th>
                <th>Total Amount</th>
                <th>Amount without Tax</th>
                <th>Transfered Amount</th>
                <th>Refunded Amount</th>
                <th>Transfer On Hold</th>
                <th>Transfer Hold Till</th>
                <th>Transfer To</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<script type="text/javascript">
    $(function () {

      var table = $('#laravel_datatable').DataTable({
          processing: true,
          serverSide: true,
          responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for Book Id: '+data['book_id'];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        },
          ajax: "{{ route('payment') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'book_id', name: 'book_id'},
                {data: 'transaction_id', name: 'transaction_id'},
                {data: 'payment_status', name: 'payment_status'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'amount_without_tax', name:'amount_without_tax'},
                {data: 'transfered_amount', name: 'transfered_amount'},
                {data: 'refunded_amount', name:'refunded_amount'},
                {data: 'on_hold', name: 'on_hold'},
                {data: 'hold_till', name: 'hold_till'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'},
          ],
          order: [[0,'desc']]
      });

    });
  </script>
@endsection
