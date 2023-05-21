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
                    <th>Plate No</th>
                    <th>Travels Name</th>
                    <th>Agent Name</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="deleteAlert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="" method="post" id="deleteform">
            @csrf
            <input type="hidden" name="status" id="bus_status">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Agent</h4>
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

<script type="text/javascript">
    $(function () {

      var table = $('#laravel_datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('bus') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'plat_no', name: 'plat_no'},
                {data: 'travels_name', name: 'travels_name'},
                {data: 'agent.name', name: 'agent.name'},
                {data: 'action', name: 'action'}
          ]
      });

    });

    function modalClose(obj)
    {
        $(obj).closest('.modal').modal('hide');
    }

    $(document).on("click", ".deleteModal", function () {
        var id = $(this).data('id');
        var type=$(this).data('type');
        $('#bus_status').val(type);

        if(type=='A')
        {
            $('.modal-title').html('Recover Bus');
            $('#deleteform').attr('action', 'bus/'+id+'/status/change');
        }
        else
        {
            $('.modal-title').html('Delete Bus');
            $('#deleteform').attr('action', 'bus/'+id+'/status/change');
        }
     });
  </script>
@endsection
