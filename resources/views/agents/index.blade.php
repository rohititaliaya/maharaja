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
                <th>Razorpay Acc Id</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<div id="razorpayAccIdModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="{{route('agent.razorpayid.update')}}" method="post">
                @method('post')
                @csrf
            <div class="modal-header">
                <h4 class="modal-title">Update Acc Id</h4>
                <button type="button" class="close" onclick="modalClose(this)">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 form-group">
                        <label for="razorpay_acc_id">Razorpay Acc Id:</label>
                        <input type="hidden" name="id">
                        <input type="text" id="razorpay_acc_id" name="razorpay_acc_id" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" onclick="modalClose(this)" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>

    </div>
</div>

<div id="deleteAlert" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form action="" method="post" id="deleteform">
            @method('delete')
            @csrf
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
          ajax: "{{ route('agents') }}",
          columns: [
                {data: 'id', name: 'id'},
                {data: 'mobile', name: 'mobile'},
                {data: 'name', name: 'name'},
                {
                    data: 'razorpay_acc_id', 
                    render: function(data, type, row, meta)
                    {
                        if(data)
                            return '<span class="text-primary">'+data+'</span> <a class="pull-right" href="#" onclick="javascript:razorpayAccIdEdit(this);" data-id="'+row['id']+'" data-razor-id="'+row['razorpay_acc_id']+'" data-name="'+row['name']+'"><i class="nav-icon fas fa-edit fa-lg "></i></a>';
                        else
                            return '<a class="pull-right" href="#" onclick="javascript:razorpayAccIdEdit(this);" data-id="'+row['id']+'" data-razor-id="" data-name="'+row['name']+'"><i class="nav-icon fas fa-edit fa-lg "></i></a>';
                    },
                },
                {data: 'action', name: 'action'}
          ]
      });

    });

    function razorpayAccIdEdit(obj)
    {
        $('#razorpayAccIdModal .modal-title').html('Update Razorpay Acc Id('+$(obj).attr('data-name')+')');
        $('#razorpayAccIdModal input[name="id"]').val($(obj).attr('data-id'));
        $('#razorpayAccIdModal input[name="razorpay_acc_id"]').val($(obj).attr('data-razor-id'));
        $('#razorpayAccIdModal').modal('show');
    }

    function modalClose(obj)
    {
        $(obj).closest('.modal').modal('hide');
    }

    $(document).on("click", ".deleteModal", function () {
        var id = $(this).data('id');
        $('#deleteform').attr('action', 'agent/'+id+'/destroy');
     });
  </script>
@endsection
