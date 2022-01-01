<?php

use App\Http\Controllers\Ticket\BookingController;
use Illuminate\Support\Facades\Route;




//Route::get('/ticket/book-ticket/add-booking',[BookingController::class,'addBookingView']);
Route::get('/ticket/book-ticket/print', [BookingController::class, 'getBookingInfoForPrintByTicket']);
Route::get('/ticket/book-ticket/get-coach-info', [BookingController::class, 'getCoachInfoAjax']);
Route::post('/ticket/book-ticket/entry-booking', [BookingController::class, 'entryBookingAjax']);
Route::group(['middleware' => ['auth']], function () {

    Route::get('/ticket/book-ticket/details', [BookingController::class, 'bookingDetailsView']);
    Route::post('/ticket/book-ticket/booking-details', [BookingController::class, 'getBookingsDataTableAjax']);

    Route::post('/ticket/book-ticket/delete-booking-ajax', [BookingController::class, 'deleteBookingAjax']);
});

