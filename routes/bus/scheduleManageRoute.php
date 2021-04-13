<?php

use App\Http\Controllers\Bus\ScheduleMangementController;
use Illuminate\Support\Facades\Route;




Route::get('/bus/schedule-management/add-schedule',[ScheduleMangementController::class,'addScheduleView']);
Route::post('/bus/schedule-management/add-schedule-ajax',[ScheduleMangementController::class,'addScheduleAjax']);

Route::get('/bus/schedule-management/edit-schedule/{id}',[ScheduleMangementController::class,'editScheduleView']);
Route::post('/bus/schedule-management/edit-schedule-ajax',[ScheduleMangementController::class,'editScheduleAjax']);

Route::get('/bus/schedule-management/schedules',[ScheduleMangementController::class,'scheduleDetalisView']);
Route::post('/bus/schedule-management/get-schedules',[ScheduleMangementController::class,'getSchedulesDataTableAjax']);

Route::post('/bus/schedule-management/delete-schedule-ajax',[ScheduleMangementController::class,'deleteScheduleAjax']);


