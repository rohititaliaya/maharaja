@extends('layouts.app')
@section('content')
<div class="container-fluid">
<div class="card p-5">
    
    <div>
        <h2>Booking List</h2>
    </div>
    <table class="table table-bordered" id="laravel_datatable">
        <thead class="card-header">
            <tr>
                <th>Id</th>
                <th>Passanger name</th>
                <th>Passanger mobile</th>
                <!-- <th>Age</th>
                <th>gender</th> -->
                <th>seats</th>
                <th>from</th>
                <th>to</th>
                <th>Total Amount</th>
                <th>Booking date</th>
                <th>Pickup place</th>
                <th>Pickup time</th>
                <th>Drop point</th>
                <th>Drop time</th>
                <th>Payment status</th>
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
          ajax: "{{ route('confirmed-seat') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'passenger_name', name: 'passenger_name'},
                {data: 'mobile', name: 'mobile'},
                // {data: 'age', name: 'age'},
                // {data: 'gender', name: 'gender'},
                {data: 'seatNo', name: 'seats'},
                {data: 'from', name: 'from'},
                {data: 'to', name: 'to'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'date', name: 'booking date'},
                {data: 'pickup_point', name: 'pickup_point'},
                {data: 'pick_time', name: 'pickup_time'},
                {data: 'drop_point', name: 'drop_point'},
                {data: 'drop_time', name: 'drop_time'},
                {data: 'payment_status', name: 'payment_status'},
          ]
      });

    });
  </script>
@endsection
