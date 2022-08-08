@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
        <div>
            <h2>Settings</h2>
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
            <div class="modal-body">
                <label for="commission_rate">Commission rate(%):</label>
                <input type="text" name="commission_rate" id="commission_rate" class="form-control" value="{{$setting->commission_rate}}" required>
            </div>
            <div class="modal-body">
                <label for="commission_rate">Tax rate(%):</label>
                <input type="text" name="tax_rate" id="tax_rate" class="form-control" value="{{$setting->tax_rate ?? ''}}" required>
            </div>
            <div class="modal-body">
                <label for="commission_rate">Cancelation charge(%):</label>
                <input type="text" name="cancelation_charge" id="cancelation_charge" class="form-control" value="{{$setting->cancelation_charge ?? ''}}" required>
            </div>
            <div class="modal-body">
                <label for="admin_user">Admin Username:</label>
                <input type="text" name="admin_user" id="admin_user" class="form-control" value="{{$setting->admin_user}}" required>
            </div>
            <div class="modal-body">
                <label for="admin_pass">Admin Password:</label>
                <input type="password" name="admin_pass" id="admin_pass" class="form-control" value="{{$setting->admin_pass}}" required>
                <input type="checkbox" onclick="Toggle()">
                <b>Show Password</b>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Update</button>
                <a href="{{ route('dashboard') }}" class="btn btn-default">Back</a>
            </div>
        </form>
            
    </div>
</div>
<script>
    // Change the type of input to password or text
        function Toggle() {
            var temp = document.getElementById("admin_pass");
            if (temp.type === "password") {
                temp.type = "text";
            }
            else {
                temp.type = "password";
            }
        }
</script>
@endsection
