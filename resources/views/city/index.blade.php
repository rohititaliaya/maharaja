@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>City List</h2>
            <button type="button" class="btn btn-success float-left my-2" data-toggle="modal"  data-target="#myModal">Add new City</button>
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
        <!-- Modal -->
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
        <form action="{{ route('city.save') }}" method="post">
            @method('POST')
            @csrf
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add City</h4>
                </div>
                <div class="modal-body">
                    <label for="city">City Name:</label>
                    <input type="text" name="city" id="city" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
            </div>
        </div>  
        
        <!-- Modal -->
        <div id="deleteAlert" class="modal fade" role="dialog">
            <div class="modal-dialog">
        <form action="" method="post" id="deleteform">
            @method('POST')
            @csrf
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete City</h4>
                </div>
                <div class="modal-body">
                    <h3>Are you sure ?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
            </div>
        </div>  
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
      
         $(document).on("click", "#deleteid", function () {
            var id = $(this).data('id');
            $('#deleteform').attr('action', 'city/'+id);
         });
    });
    
   
  </script>
  
@endsection
