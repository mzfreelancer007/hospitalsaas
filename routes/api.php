<?php

use App\Http\Controllers\Api\V1\AppointmentController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\DoctorController;
use App\Http\Controllers\Api\V1\OnboardingController;
use App\Http\Controllers\Api\V1\PatientController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function (): void {
    Route::post('/onboarding/hospitals', [OnboardingController::class, 'store'])->middleware('throttle:10,1');

    Route::prefix('/auth')->group(function (): void {
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'tenant.context']);
    });

    Route::middleware(['auth:sanctum', 'tenant.context'])->group(function (): void {
        Route::apiResource('users', UserController::class)->except(['destroy'])->middleware('permission:users.view');
        Route::patch('/users/{id}/status', [UserController::class, 'status'])->middleware('permission:users.status');

        Route::apiResource('patients', PatientController::class)->except(['destroy']);
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('doctors', DoctorController::class);

        Route::get('/appointments', [AppointmentController::class, 'index'])->middleware('permission:appointments.view');
        Route::post('/appointments', [AppointmentController::class, 'store'])->middleware('permission:appointments.create');
        Route::patch('/appointments/{id}', [AppointmentController::class, 'update'])->middleware('permission:appointments.update');
    });
});
