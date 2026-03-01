<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;


Route::get('/', function () {
    return view('Auth.Login');
});


Route::post('/login-user',[AuthController::class,'login'])->name('login.user');
Route::post('/logout-user',[AuthController::class,'logout'])->name('logout');

Route::get('/user-dashboard',[DashboardController::class,'dashboard'])->name('dashboard');
