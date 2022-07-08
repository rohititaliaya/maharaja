@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>Edit City</h2>
        </div>
        
        <form action="{{ route('city.update',$city->id) }}" method="post">
            @method('POST')
            @csrf
            <div class="modal-body">
                <label for="city">City Name:</label>
                <input type="text" name="city" id="city" class="form-control" value="{{$city->name}}" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update</button>
                <a href="{{ route('city') }}" class="btn btn-default">Back</a>
            </div>
        </form>
            
    </div>
</div>
@endsection
