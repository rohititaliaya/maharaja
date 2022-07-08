<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\RoutesController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PickupPointsController;
use App\Http\Controllers\DropPointsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\ConfirmedSeatController;
use App\Http\Controllers\Admin\AdminController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ------------- filter buses -------------------//
Route::post('buses',[BusController::class, 'index'])->name('buses');
Route::post('storebuses',[BusController::class, 'store'])->name('buses');
Route::post('filterbus',[BusController::class,'filterbus'])->name('filterbus');
Route::post('delete-bus',[BusController::class,'destroy'])->name('delete-bus');
Route::post('show-hide-bus',[BusController::class,'showHideBus'])->name('show-hide-bus');

// ------------ city api -------------------//
Route::resource('cities',CityController::class)->names('cities');


//---------  get buses with routes --------------// 
Route::get('getBuses',[BusController::class,'getBuses']);

// --------------- agent available or not ---------------//
Route::post('agents',[AgentController::class, 'store'])->name('agents');
Route::post('checkAgent',[AgentController::class,'checkAgent'])->name('checkAgent');

// --------------- pickup points ---------------/
Route::resource('pockup-points',PickupPointsController::class)->names('pockup-points');
Route::post('pockup-points',[PickupPointsController::class,'store'])->name('pockup-points');
Route::post('get-pickup-points',[PickupPointsController::class,'getPickupPoints'])->name('get-pickup-points');
Route::post('get-p-points',[PickupPointsController::class,'getpoints'])->name('get-p-points');
Route::post('update-pickup-points',[PickupPointsController::class,'update'])->name('pockup-points');

// --------------- drop points ---------------/
Route::resource('drop-points',DropPointsController::class)->names('drop-points');
Route::post('drop-points',[DropPointsController::class,'store'])->name('drop-points');
Route::post('get-drop-points',[DropPointsController::class,'getDropPoints'])->name('get-drop-points');
Route::post('get-d-points',[DropPointsController::class,'getpoints'])->name('get-d-points');
Route::post('update-drop-points',[DropPointsController::class,'update'])->name('drop-points');

// ----------- routes api -----------------------//
Route::post('delete-route',[RoutesController::class,'destroy'])->name('delete-route');
Route::post('routes',[RoutesController::class,'store'])->name('routes');
Route::post('getroutes',[RoutesController::class,'index'])->name('routes');
Route::post('get-bus-routes',[RoutesController::class,'index2'])->name('get-bus-routes');
Route::post('update-bus-and-routes',[RoutesController::class,'updateBusAndRoutes'])->name('update-bus-and-routes');
Route::post('update-routes',[RoutesController::class,'update'])->name('update-routes');

// ------- create user ----------//
Route::post('create-user', [UserController::class,'store'])->name('create-user');

// ///////// Proceed Book ////////// //
//--------- seats array --------//
Route::post('get-seats-array',[SeatController::class,'index'])->name('get-seats-array');
// -------- saving selected seats ----------- //
Route::post('store-selected-seat',[SeatController::class,'store'])->name('store-selected-seat');
// --------- get pickup and drop points by bus ----- //
Route::post('get-pickup-drop',[ConfirmedSeatController::class,'index'])->name('get-pickup-drop');
// ---------- store contact info ---------------//
Route::post('store-contact-info',[ConfirmedSeatController::class,'store'])->name('store-contact-info');

// -------------------- get booked seat ----------------- //    
Route::post('get-booked-seats',[ConfirmedSeatController::class,'show'])->name('get-booked-seats');  
Route::post('get-cansal-seats',[ConfirmedSeatController::class,'showCansal'])->name('get-cansal-seats');  

// -------- get-empty-points ------- //
Route::post('cansal-seat',[ConfirmedSeatController::class,'cansal'])->name('cansal-seat');  

Route::post('get-user-booked',[ConfirmedSeatController::class,'usershow'])->name('get-user-booked');  
Route::post('get-user-cansal',[ConfirmedSeatController::class,'usershowCansal'])->name('get-user-cansal');  

// ---------- payment api --------------//
Route::post('payment-status',[ConfirmedSeatController::class,'payment_status'])->name('payment-status');  

Route::post('privacy',[AdminController::class,'privacy'])->name('privacy');  