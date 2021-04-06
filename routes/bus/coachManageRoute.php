<?php

use App\Http\Controllers\Bus\CoachManagementController;
use Illuminate\Support\Facades\Route;




Route::get('/bus/coach-management/add-coach',[CoachManagementController::class,'addCoachView']);
Route::post('/bus/coach-management/add-coach-ajax',[CoachManagementController::class,'addCoachAjax']);
Route::get('/bus/coach-management/edit-coach',[CoachManagementController::class,'editCoachView']);
