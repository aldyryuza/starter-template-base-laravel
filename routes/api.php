<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\master\DepartementController;
use App\Http\Controllers\api\master\JobTitleController;
use App\Http\Controllers\api\master\RolesController;
use App\Http\Controllers\api\master\SubsidiaryController;
use App\Http\Controllers\api\MenuController;
use App\Http\Controllers\api\PermissionController;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);


    // MENU
    Route::post('/settings/menu/getData', [MenuController::class, 'getData']);
    Route::post('/settings/menu/submit', [MenuController::class, 'submit']);
    Route::delete('/settings/menu/delete/{id}', [MenuController::class, 'delete']);
    // PERMISSION
    Route::post('/settings/permissions/getData', [PermissionController::class, 'getData']);
    Route::post('/settings/permissions/submit', [PermissionController::class, 'submit']);
    Route::delete('/settings/permissions/delete/{id}', [PermissionController::class, 'delete']);
    // ROLES
    Route::post('/master/roles/getData', [RolesController::class, 'getData']);
    Route::post('/master/roles/submit', [RolesController::class, 'submit']);
    Route::delete('/master/roles/delete/{id}', [RolesController::class, 'delete']);
    // DEPARTEMENT
    Route::post('/master/department/getData', [DepartementController::class, 'getData']);
    Route::post('/master/department/submit', [DepartementController::class, 'submit']);
    Route::delete('/master/department/delete/{id}', [DepartementController::class, 'delete']);
    // JOB TITLE
    Route::post('/master/job_title/getData', [JobTitleController::class, 'getData']);
    Route::post('/master/job_title/submit', [JobTitleController::class, 'submit']);
    Route::delete('/master/job_title/delete/{id}', [JobTitleController::class, 'delete']);
    // JOB TITLE
    Route::post('/master/subsidiary/getData', [SubsidiaryController::class, 'getData']);
    Route::post('/master/subsidiary/submit', [SubsidiaryController::class, 'submit']);
    Route::delete('/master/subsidiary/delete/{id}', [SubsidiaryController::class, 'delete']);
});


//
