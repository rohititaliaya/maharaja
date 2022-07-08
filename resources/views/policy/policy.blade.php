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
                <input type="text" name="email" id="email" class="form-control" value="{{$setting->email}}" required>
            </div>
            <div class="modal-body">
                <label for="mobile">Mobile:</label>
                <input type="text" name="mobile" id="mobile" class="form-control" value="{{$setting->mobile}}" required>
            </div>
            <div class="modal-body">
                <label for="privacy_policy">Privacy-Policy:</label>
                <input type="text" name="privacy_policy" id="privacy_policy" class="form-control" value="{{$setting->privacy_policy}}" required>
            </div>
            <div class="modal-body">
                <label for="razorpay_apikey">Razor pay api key:</label>
                <input type="text" name="razorpay_apikey" id="razorpay_apikey" class="form-control" value="{{$setting->razorpay_apikey}}" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update</button>
                <a href="{{ route('dashboard') }}" class="btn btn-default">Back</a>
            </div>
        </form>
            
    </div>
</div>
@endsection
