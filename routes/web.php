<?php

use App\Http\Controllers\web\DashboardController;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\MenuController;
use App\Http\Controllers\web\PermissionController;
use App\Http\Controllers\web\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'index'])->name('login.index');
Route::get('/auth/login', [AuthController::class, 'index'])->name('auth.login');
Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::get('/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/auth/save_session', [AuthController::class, 'save_session'])->name('auth.save_session');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::get('/master/users', [UserController::class, 'index'])->name('users.index');

// MENU
Route::get('/settings/menu', [MenuController::class, 'index'])->name('settings.menu.index');
Route::get('/settings/menu/create', [MenuController::class, 'create'])->name('settings.menu.create');
Route::get('/settings/menu/edit/{id}', [MenuController::class, 'edit'])->name('settings.menu.edit');
Route::get('/settings/menu/detail/{id}', [MenuController::class, 'detail'])->name('settings.menu.detail');
// PERMISSION
Route::get('/settings/permissions', [PermissionController::class, 'index'])->name('settings.permission.index');
Route::get('/settings/permissions/create', [PermissionController::class, 'create'])->name('settings.permission.create');
Route::get('/settings/permissions/edit/{id}', [PermissionController::class, 'edit'])->name('settings.permission.edit');
Route::get('/settings/permissions/detail/{id}', [PermissionController::class, 'detail'])->name('settings.permission.detail');
