@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>Agent Banks List</h2>
        </div>
        <table class="table table-bordered" id="laravel_datatable">
            <thead class="card-header">
            <tr>
                <th>Id</th>
                <th>Agent Name</th>
                <th>Buses</th>
                <th>Account Number</th>
                <th>Banificary Name</th>
                <th>IFSC Code</th>
                <th>Bank Name</th>
                <th>City Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Account Type</th>
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
          ajax: "{{ route('agent.bank') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'agent.name', name: 'agent.name'},
                {data: 'buses', name: 'buses'},
                {data: 'account_number', name: 'account_number'},
                {data: 'banificary_name', name: 'banificary_name'},
                {data: 'ifsc_code', name: 'ifsc_code'},
                {data: 'bank_name', name: 'bank_name'},
                {data: 'city_name', name: 'city_name'},
                {data: 'email', name: 'email'},
                {data: 'mobile', name: 'mobile'},
                {data: 'ac_type', name: 'ac_type'},
                {data: 'action', name: 'action'}
          ]
      });

    });
  </script>
@endsection
