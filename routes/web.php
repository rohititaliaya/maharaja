<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
#------> login link
Route::get('/login', [App\Http\Controllers\Admin\AdminController::class, 'login'])->name('login');
Route::post('/loginpost', [App\Http\Controllers\Admin\AdminController::class, 'loginpost'])->name('login.post');
Route::get('/logout', [App\Http\Controllers\Admin\AdminController::class, 'logout'])->name('logout');

#------> admin dashboard link
Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');

Route::get('users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users');

Route::get('agent/bank', [App\Http\Controllers\Admin\BankDetailController::class, 'index'])->name('agent.bank');
Route::get('agent/bank/{id}/edit', [App\Http\Controllers\Admin\BankDetailController::class, 'edit'])->name('agent.bank.edit');
Route::post('agent/bank/{id}', [App\Http\Controllers\Admin\BankDetailController::class, 'update'])->name('agent.bank.update');
Route::get('agents', [App\Http\Controllers\Admin\AgentController::class, 'index'])->name('agents');
Route::get('agent/agent-approve/{id}', [App\Http\Controllers\Admin\AgentController::class, 'approve']);
Route::get('agent/agent-dis-approve/{id}', [App\Http\Controllers\Admin\AgentController::class, 'DisApprove']);
Route::post('agent/razorpay-id/update',[App\Http\Controllers\Admin\AgentController::class, 'razorpayIdUpdate'])->name('agent.razorpayid.update');
Route::delete('agent/{agent}/destroy',[App\Http\Controllers\Admin\AgentController::class,'destroy'])->name('agent.destroy');
Route::get('bus', [App\Http\Controllers\Admin\BusController::class, 'index'])->name('bus');
Route::post('bus/{bus}/status/change',[App\Http\Controllers\Admin\BusController::class,'statusChange'])->name('bus.status.change');

#---------- city crud ----------#
Route::get('city', [App\Http\Controllers\Admin\CityController::class, 'index'])->name('city');
Route::post('city/{id}', [App\Http\Controllers\Admin\CityController::class, 'destroy'])->name('city.destroy');
Route::post('savecity', [App\Http\Controllers\Admin\CityController::class, 'store'])->name('city.save');
Route::get('city/{id}/edit', [App\Http\Controllers\Admin\CityController::class, 'edit'])->name('city.edit');
Route::post('updatecity/{id}', [App\Http\Controllers\Admin\CityController::class, 'update'])->name('city.update');

Route::get('confirmed-seat', [App\Http\Controllers\Admin\ConfirmedSeatController::class, 'index'])->name('confirmed-seat');
Route::get('date-price', [App\Http\Controllers\Admin\DatePriceController::class, 'index'])->name('date-price');
Route::get('drop-point', [App\Http\Controllers\Admin\DropPointController::class, 'index'])->name('drop-point');
Route::get('payment', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payment');
Route::post('payment/transfer/{payment}',[App\Http\Controllers\Admin\PaymentController::class,'paymentTransfer'])->name('payment.transfer');
/*****Razor Webhooks*****/
Route::post('payment/razorpay/webhook/refundSettled',[App\Http\Controllers\Admin\RazorHookController::class,'refundSettled']);
Route::post('payment/razorpay/webhook/transferSettled',[App\Http\Controllers\Admin\RazorHookController::class,'transferSettled']);
Route::post('payment/razorpay/webhook/settlement-processed',[App\Http\Controllers\Admin\RazorHookController::class,'settlementProcessed']);
/*****Razor Webhooks*****/

Route::get('pickup-point', [App\Http\Controllers\Admin\PickupPointController::class, 'index'])->name('pickup-point');
Route::get('route', [App\Http\Controllers\Admin\RouteController::class, 'index'])->name('route');
Route::get('seat', [App\Http\Controllers\Admin\SeatController::class, 'index'])->name('seat');
// Route::get('agents-filter', [App\Http\Controllers\Admin\AgentController::class, 'getCustomFilterData'])->name('agent.table');

#policy update
Route::get('policy',[App\Http\Controllers\Admin\AdminController::class,'getPolicy'])->name('policy');  
Route::post('privacy-policy',[App\Http\Controllers\Admin\AdminController::class,'privacyPolicy'])->name('privacy.policy');  
