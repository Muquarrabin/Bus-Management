<?php

use App\Http\Controllers\Bus\CoachManagementController;
use Illuminate\Support\Facades\Route;




Route::get('/bus/coach-management/add-coach',[CoachManagementController::class,'addCoachView']);
Route::post('/bus/coach-management/add-coach-ajax',[CoachManagementController::class,'addCoachAjax']);

Route::get('/bus/coach-management/edit-coach/{id}',[CoachManagementController::class,'editCoachView']);
Route::post('/bus/coach-management/edit-coach-ajax',[CoachManagementController::class,'editCoachAjax']);

Route::get('/bus/coach-management/coaches',[CoachManagementController::class,'coachDetalisView']);
Route::post('/bus/coach-management/get-coaches',[CoachManagementController::class,'getCoachesDataTableAjax']);

Route::post('/bus/coach-management/delete-coach-ajax',[CoachManagementController::class,'deleteCoachAjax']);


