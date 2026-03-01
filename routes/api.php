<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;

Route::Post('/register-user', [AuthController::class, 'create'])->name('register-user');



// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
