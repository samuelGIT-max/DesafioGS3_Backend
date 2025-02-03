<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProfileController;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Users
    Route::apiResource('users', UserController::class)->except(['create', 'edit']);
    
    // Profiles
    Route::apiResource('profiles', ProfileController::class)->except(['create', 'edit']);
    
    // Relacionamentos
    Route::get('users/by-profile/{profile}', [UserController::class, 'getUsersByProfile']);
});
