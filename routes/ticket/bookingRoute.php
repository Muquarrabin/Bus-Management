<?php

use App\Http\Controllers\Ticket\BookingController;
use Illuminate\Support\Facades\Route;




Route::get('/ticket/book-ticket/add-booking',[BookingController::class,'addBookingView']);
Route::get('/ticket/book-ticket/get-coach-info',[BookingController::class,'getCoachInfoAjax']);

Route::post('/ticket/book-ticket/entry-booking',[BookingController::class,'entryBookingAjax']);

// Route::get('/ticket/seat-configuration/edit-seat-configuration/{id}',[SeatConfigurationController::class,'editSeatConfigView']);
// Route::post('/ticket/seat-configuration/edit-seat-configuration-ajax',[SeatConfigurationController::class,'editSeatConfigAjax']);

// Route::get('/ticket/seat-configuration/details',[SeatConfigurationController::class,'seatConfigDetailsView']);
// Route::post('/ticket/seat-configuration/get-details',[SeatConfigurationController::class,'getSeatConfigDatatableAjax']);


// Route::post('/ticket/seat-configuration/delete-seat-config-ajax',[SeatConfigurationController::class,'deleteSeatConfigAjax']);


