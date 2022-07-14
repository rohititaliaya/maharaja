@extends('layouts.app')
@section('content')
<div class="container-fluid">
<div class="card p-5">
    
    <div>
        <h2>Booking List</h2>
    </div>
    <div class="card">
        <div class="card-body">
            {{-- <form action="/confirmed-seat" method="get"> --}}
                <div class=" d-flex">
                    <div class="form-group px-3">
                        <label><strong> Select Bus :</strong></label>
                        <select id='bus_id' name="bus_id" class="form-control" style="width: 200px">
                            <option value="">--Select Status--</option>
                            @foreach ($buses as $item)
                                <option value="{{$item->id}}">{{$item->travels_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group px-3">
                        <label><strong> Select Booking date :</strong></label>
                        <input type="date" id="date" name="date"  class="form-control">
                    </div>

                    <div class="form-group px-3">
                        <label><strong>Payment Status :</strong></label>
                        <select id='payment_status' name="pstatus" class="form-control" style="width: 200px">
                            <option value="">--Select Status--</option>
                            <option value="1">success</option>
                            <option value="0">failed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><strong>Seat Status :</strong></label>
                        <select id='seat_status' name="status" class="form-control" style="width: 200px">
                            <option value="">--Select Status--</option>
                            <option value="0">cancelled</option>
                            <option value="1">confirmed</option>
                        </select>
                    </div>

                </div>
                {{-- <button type="submit" class="btn btn-info">Filter</button> --}}
            {{-- </form> --}}
        </div>
    </div>
    <table class="table table-bordered" id="laravel_datatable">
        <thead class="card-header">
            <tr>
                <th>Id</th>
                <th>Bus name</th>
                <th>Passanger name</th>
                <th>Passanger mobile</th>
                <th>seats</th>
                <th>from</th>
                <th>to</th>
                <th>Total Amount</th>
                <th>Booking date</th>
                <th>Pickup place</th>
                <th>Pickup time</th>
                <th>Drop point</th>
                <th>Drop time</th>
                <th>Seat status</th>
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
          ajax: {
            url:"{{ route('confirmed-seat') }}",    
            data: function (d) {
                d.payment_status = $('#payment_status').val(),
                d.status = $('#seat_status').val(),
                d.bus_id = $('#bus_id').val(),
                d.date = $('#date').val()
            }
        },
          columns: [
                {data: 'id', name: 'id'},
                {data: 'bus_name', name: 'bus_name'},
                {data: 'passenger_name', name: 'passenger_name'},
                {data: 'mobile', name: 'mobile'},
                // {data: 'gender', name: 'gender'},
                {data: 'seatNo', name: 'seatNo'},
                {data: 'from', name: 'from'},
                {data: 'to', name: 'to'},
                {data: 'total_amount', name: 'total_amount'},
                {data: 'date', name: 'date'},
                {data: 'pickup_point', name: 'pickup_point'},
                {data: 'pick_time', name: 'pick_time'},
                {data: 'drop_point', name: 'drop_point'},
                {data: 'drop_time', name: 'drop_time'},
                {data: 'seat_status', name: 'seat_status'},
                {data: 'payment_status', name: 'payment_status'},
          ]
      });

        $('#payment_status').change(function(){
            table.draw();
        });

        $('#seat_status').change(function(){
            table.draw();
        });

        $('#bus_id').change(function(){
            table.draw();
        });

        $('#date').change(function(){
            table.draw();
        });
    });
  </script>
@endsection
