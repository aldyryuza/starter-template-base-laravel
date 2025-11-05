<?php

use App\Http\Controllers\web\DashboardController;
use App\Http\Controllers\web\LoginController;
use App\Http\Controllers\web\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');


Route::get('/master/users', [UserController::class, 'index'])->name('users.index');
