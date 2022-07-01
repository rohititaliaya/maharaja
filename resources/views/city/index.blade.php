@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>City List</h2>
            <button type="button" class="btn btn-success float-left my-2">Add new City</button>
        </div>
        <table class="table table-bordered" id="laravel_datatable">
            <thead class="card-header">
                <tr>
                    <th>Id</th>
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
          ajax: "{{ route('city') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'action', name: 'action'}
          ]
      });

    });
  </script>
@endsection
