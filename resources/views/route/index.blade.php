@extends('layouts.app')
@section('content')
<div class="container">

<div>
    <h2>Routes List</h2>
</div>
    <table class="table table-bordered" id="laravel_datatable">
        <thead>
        <tr>
        <th>Id</th>
        <th>Bus Name</th>
        <th>From</th>
        <th>To</th>
        <th>Price</th>
        <th>Status</th>
    </tr>
</thead>
</table>
</div>

<script type="text/javascript">
    $(function () {

      var table = $('#laravel_datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('route') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'bus.bus_name', name: 'bus.bus_name'},
                {data: 'to.name', name: 'to.name'},
                {data: 'from.name', name: 'from.name'},
                {data: 'price', name: 'price'},
                {data: 'status', name: 'status'}
          ]
      });

    });
  </script>
@endsection
