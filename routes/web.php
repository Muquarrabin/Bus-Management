<?php

use App\Http\Controllers\Bus\CoachManagementController;
use App\Http\Controllers\Ticket\BookingController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/',[BookingController::class,'addBookingView']);

//coach management
include('bus/coachManageRoute.php');
//schedule management
include('bus/scheduleManageRoute.php');
//seat configuration
include('ticket/seatConfigRoute.php');
//seat booking
include('ticket/bookingRoute.php');




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
