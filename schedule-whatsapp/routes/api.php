<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UtilsController;
use App\Http\Controllers\WorkingDaysController;
use App\Http\Controllers\UnavailableDaysController;
use App\Models\Service;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.key')->group(function() {
    
    Route::post('/clients', [ClientController::class, 'store']);
    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments/user', [AppointmentController::class, 'getAppointmentsByUserId']);
    Route::get('/services', [ServiceController::class, 'webIndex']);
    Route::get('/utils/user-client-ids', [UtilsController::class, 'getUserAndClientIdsByPhone']);
    Route::get('/working-days/user', [WorkingDaysController::class, 'getWorkingDaysByUserId']);
    Route::get('/unavailable-days/user', [UnavailableDaysController::class, 'getUnavailableDaysByUserId']);
});
