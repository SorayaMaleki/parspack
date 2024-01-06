<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Authentication routes
Route::post('/register', [UsersController::class, 'register'])->name('register');
Route::post('/login', [UsersController::class, 'login'])->name('login');
Route::post('/logout', [UsersController::class, 'logout'])
  ->middleware(['auth:sanctum'])
  ->name('logout');

// API resource routes with middleware
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('products', ProductsController::class);
    Route::apiResource('comments', CommentsController::class);
});
