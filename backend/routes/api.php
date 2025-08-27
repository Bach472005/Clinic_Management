<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SchedulePsychologistController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    // Auth-related
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // User profile
    Route::get('/user/profile', [UserAccountController::class, 'index']);
    Route::put('/user/profile', [UserAccountController::class, 'updateProfile']);
    Route::put('/user/password', [UserAccountController::class, 'updatePassword']);

    // Patient
    Route::resource('patient', PatientController::class)
        ->only('index');

    // Appointments
    Route::post('/appointments',[ AppointmentController::class, 'store']);
    Route::get('/psychologist/{psychologist}/schedule', [SchedulePsychologistController::class, 'getAvailableSchedules']);
});
