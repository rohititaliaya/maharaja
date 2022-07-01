@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>Agents List</h2>
        </div>
        <table class="table table-bordered" id="laravel_datatable">
            <thead class="card-header">
            <tr>
                <th>Id</th>
                <th>mobile</th>
                <th>name</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
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
                {data: 'action', name: 'action'}
          ]
      });

    });
  </script>
@endsection
