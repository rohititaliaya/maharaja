@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h3>Users List</h3>
        </div>
        <table class="table table-bordered" id="laravel_datatable">
            <thead class="card-header">
                <tr>
                    <th>Id</th>
                    <th>mobile</th>
                    <th>craeted at</th>
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
          ajax: "{{ route('users') }}",
          columns: [
                    {data: 'id', name: 'id'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'created_at', name: 'created_at'},
        ],
      });

    });
</script>
@endsection
