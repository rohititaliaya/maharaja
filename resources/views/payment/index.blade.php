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
                <th>Customer Name</th>
                <th>User ID</th>
                <th>Status</th>
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
          ajax: "{{ route('payment') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'book.passenger_name', name: 'book.passenger_name'},
                {data: 'user_id', name: 'user_id'},
                {data: 'status', name: 'status'},
                {data: 'on_hold', name: 'on_hold'},
                {data: 'hold_till', name: 'hold_till'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'},
          ]
      });

    });
  </script>
@endsection
