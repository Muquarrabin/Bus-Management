<?php

use App\Http\Controllers\Ticket\SeatConfigurationController;
use Illuminate\Support\Facades\Route;




Route::get('/ticket/seat-configuration/add-seat-configuration',[SeatConfigurationController::class,'addSeatConfigView']);
Route::post('/ticket/seat-configuration/add-seat-configuration-ajax',[SeatConfigurationController::class,'addSeatConfigAjax']);

Route::get('/ticket/seat-configuration/edit-seat-configuration/{id}',[SeatConfigurationController::class,'editSeatConfigView']);
Route::post('/ticket/seat-configuration/edit-seat-configuration-ajax',[SeatConfigurationController::class,'editSeatConfigAjax']);

Route::get('/ticket/seat-configuration/details',[SeatConfigurationController::class,'seatConfigDetailsView']);
Route::post('/ticket/seat-configuration/get-details',[SeatConfigurationController::class,'getSeatConfigDatatableAjax']);


Route::post('/ticket/seat-configuration/delete-seat-config-ajax',[SeatConfigurationController::class,'deleteSeatConfigAjax']);


