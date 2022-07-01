@extends('layouts.app')
@section('content')
<div class="container">

<div>
    <h2>Date Prices List</h2>
</div>
    <table class="table table-bordered" id="laravel_datatable">
        <thead>
        <tr>
        <th>Id</th>
        <th>Date</th>
        <th>Price</th>
        {{-- <th>Route Name</th> --}}
    </tr>
</thead>
</table>
</div>

<script type="text/javascript">
    $(function () {

      var table = $('#laravel_datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('date-price') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'date', name: 'date'},
                {data: 'price', name: 'price'},
                // {data: 'created_at', name: 'created_at'},
                // {data: 'updated_at', name: 'updated_at'}
          ]
      });

    });
  </script>
@endsection
