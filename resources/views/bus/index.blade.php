@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>Bus List</h2>
        </div>
        <table class="table table-bordered" id="laravel_datatable">
            <thead class="card-header">
                <tr>
                    <th>Id</th>
                    <th>Travels Name</th>
                    <th>Agent Name</th>
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
          ajax: "{{ route('bus') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'travels_name', name: 'travels_name'},
                {data: 'agent.name', name: 'agent.name'},
          ]
      });

    });
  </script>
@endsection
