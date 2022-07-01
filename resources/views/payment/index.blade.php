@extends('layouts.app')
@section('content')
<div class="container">

<div>
    <h2>Payment List</h2>
</div>
    <table class="table table-bordered" id="laravel_datatable">
        <thead>
        <tr>
        <th>Id</th>
        <th>Customer Name</th>
        <th>User ID</th>
        <th>Status</th>
        <th>Created at</th>
        <th>Updated at</th>
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
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'}
          ]
      });

    });
  </script>
@endsection
