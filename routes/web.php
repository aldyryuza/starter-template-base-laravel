<?php

use App\Http\Controllers\web\DashboardController;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index'])->name('login.index');
Route::get('/auth/login', [AuthController::class, 'index'])->name('login.index');
Route::get('/auth/register', [AuthController::class, 'register'])->name('register.index');
Route::post('/auth/save_session', [AuthController::class, 'save_session'])->name('auth.save_session');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/master/users', [UserController::class, 'index'])->name('users.index');
