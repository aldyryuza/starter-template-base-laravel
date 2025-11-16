<?php

use App\Http\Controllers\web\DashboardController;
use App\Http\Controllers\web\AuthController;
use App\Http\Controllers\web\master\DepartementController;
use App\Http\Controllers\web\master\EmployeeController;
use App\Http\Controllers\web\master\JobTitleController;
use App\Http\Controllers\web\master\RolesController;
use App\Http\Controllers\web\master\SubsidiaryController;
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
// ROLES
Route::get('/master/roles', [RolesController::class, 'index'])->name('master.roles.index');
Route::get('/master/roles/create', [RolesController::class, 'create'])->name('master.roles.create');
Route::get('/master/roles/edit/{id}', [RolesController::class, 'edit'])->name('master.roles.edit');
Route::get('/master/roles/detail/{id}', [RolesController::class, 'detail'])->name('master.roles.detail');
// DEPARTEMENT
Route::get('/master/department', [DepartementController::class, 'index'])->name('master.department.index');
Route::get('/master/department/create', [DepartementController::class, 'create'])->name('master.department.create');
Route::get('/master/department/edit/{id}', [DepartementController::class, 'edit'])->name('master.department.edit');
Route::get('/master/department/detail/{id}', [DepartementController::class, 'detail'])->name('master.department.detail');
// DEPARTEMENT
Route::get('/master/job_title', [JobTitleController::class, 'index'])->name('master.job_title.index');
Route::get('/master/job_title/create', [JobTitleController::class, 'create'])->name('master.job_title.create');
Route::get('/master/job_title/edit/{id}', [JobTitleController::class, 'edit'])->name('master.job_title.edit');
Route::get('/master/job_title/detail/{id}', [JobTitleController::class, 'detail'])->name('master.job_title.detail');
// SUBSIDIARY
Route::get('/master/subsidiary', [SubsidiaryController::class, 'index'])->name('master.subsidiary.index');
Route::get('/master/subsidiary/create', [SubsidiaryController::class, 'create'])->name('master.subsidiary.create');
Route::get('/master/subsidiary/edit/{id}', [SubsidiaryController::class, 'edit'])->name('master.subsidiary.edit');
Route::get('/master/subsidiary/detail/{id}', [SubsidiaryController::class, 'detail'])->name('master.subsidiary.detail');
// EMPLOYEE
Route::get('/master/employee', [EmployeeController::class, 'index'])->name('master.employee.index');
Route::get('/master/employee/create', [EmployeeController::class, 'create'])->name('master.employee.create');
Route::get('/master/employee/edit/{id}', [EmployeeController::class, 'edit'])->name('master.employee.edit');
Route::get('/master/employee/detail/{id}', [EmployeeController::class, 'detail'])->name('master.employee.detail');
