@extends('layouts.app')
@section('content')
<div class="container-fluid">
    <div class="card p-5">
       <h1>Edit Agent Bank Detail</h1>
       <form action="{{ route('agent.bank.update',  $bank['id']) }}" method="post"> 
           @csrf
           @method('POST')
            <div class="modal-body">
                    <label for="city">Account Number:</label>
                    <input type="text" name="account_number" id="account_number" class="form-control" value="{{ $bank['account_number'] }}" required="">
            </div>
                    <div class="modal-body">
                    <label for="city">Account holder name:</label>
                    <input type="text" name="banificary_name" id="banificary_name" class="form-control" value="{{ $bank['banificary_name'] }}" required="">
            </div>
             <div class="modal-body">
                    <label for="city">IFSC code:</label>
                    <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" value="{{ $bank['ifsc_code'] }}" required="">
            </div>
            <div class="modal-body">
                    <label for="city">Bank name:</label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ $bank['bank_name'] }}" required="">
            </div>
            <div class="modal-body">
                    <label for="city">A\C Type:</label>
                   <select name="ac_type" id="ac_type" class="form-control"> 
                      <option value="Saving" @if($bank['ac_type']== 'Saving') selected @endif>Saving</option>
                      <option value="Current" @if($bank['ac_type']== 'Current') selected @endif >Current</option>
                    </select>
            </div>
            <div class="modal-body">
                    <label for="city">city name:</label>
                    <input type="text" name="city_name" id="city_name" class="form-control" value="{{ $bank['city_name'] }}" required="">
            </div>
            <div class="modal-body">
                    <label for="city">Mobile no:</label>
                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ $bank['mobile'] }}" required="">
            </div>
            
           <div class="modal-body">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $bank['email'] }}" required="">
            </div>
            
            <div class="modal-body">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('agent.bank') }}" class="btn btn-light">Back</a>
                    <!--<input type="submit">-->
            </div>
    </form>
    </div>
</div>
@endsection
