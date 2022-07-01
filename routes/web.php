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

Route::get('/', function () {
    return view('welcome');
});

Route::get('users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('users');
// Route::get('users-filter', [App\Http\Controllers\Admin\UsersController::class, 'getCustomFilterData'])->name('user.table');

Route::get('agents', [App\Http\Controllers\Admin\AgentController::class, 'index'])->name('agents');
Route::get('agent/agent-approve/{id}', [App\Http\Controllers\Admin\AgentController::class, 'approve']);
Route::get('agent/agent-dis-approve/{id}', [App\Http\Controllers\Admin\AgentController::class, 'DisApprove']);
Route::get('bus', [App\Http\Controllers\Admin\BusController::class, 'index'])->name('bus');
Route::get('city', [App\Http\Controllers\Admin\CityController::class, 'index'])->name('city');
Route::get('confirmed-seat', [App\Http\Controllers\Admin\ConfirmedSeatController::class, 'index'])->name('confirmed-seat');
Route::get('date-price', [App\Http\Controllers\Admin\DatePriceController::class, 'index'])->name('date-price');
Route::get('drop-point', [App\Http\Controllers\Admin\DropPointController::class, 'index'])->name('drop-point');
Route::get('payment', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payment');
Route::get('pickup-point', [App\Http\Controllers\Admin\PickupPointController::class, 'index'])->name('pickup-point');
Route::get('route', [App\Http\Controllers\Admin\RouteController::class, 'index'])->name('route');
Route::get('seat', [App\Http\Controllers\Admin\SeatController::class, 'index'])->name('seat');
// Route::get('agents-filter', [App\Http\Controllers\Admin\AgentController::class, 'getCustomFilterData'])->name('agent.table');
