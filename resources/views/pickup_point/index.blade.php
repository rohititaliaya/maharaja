@extends('layouts.app')
@section('content')
<div class="container">

<div>
    <h2>Agents List</h2>
</div>
    <table class="table table-bordered" id="laravel_datatable">
        <thead>
        <tr>
        <th>Id</th>
        <th>mobile</th>
        <th>name</th>
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
          ajax: "{{ route('agents') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'mobile', name: 'mobile'},
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'}
          ]
      });

    });
  </script>
@endsection
