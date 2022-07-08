@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>Privacy-Policy</h2>
        </div>
        
        <form action="{{ route('privacy.policy') }}" method="post">
            @method('POST')
            @csrf
            <div class="modal-body">
                <label for="city">Email:</label>
                <input type="text" name="email" id="email" class="form-control" value="{{config('AdminPolicy.email')}}" required>
            </div>
            <div class="modal-body">
                <label for="mobile">Mobile:</label>
                <input type="text" name="mobile" id="mobile" class="form-control" value="{{config('AdminPolicy.mobile')}}" required>
            </div>
            <div class="modal-body">
                <label for="privacy_policy">Mobile:</label>
                <input type="text" name="privacy_policy" id="privacy_policy" class="form-control" value="{{config('AdminPolicy.privacy_policy')}}" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update</button>
                <a href="{{ route('dashboard') }}" class="btn btn-default">Back</a>
            </div>
        </form>
            
    </div>
</div>
@endsection
