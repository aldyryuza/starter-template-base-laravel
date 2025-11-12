<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\MenuController;
use Illuminate\Support\Facades\Route;


Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);


    // MENU
    Route::post('/settings/menu/getData', [MenuController::class, 'getData']);
    Route::post('/settings/menu/submit', [MenuController::class, 'submit']);
    Route::delete('/settings/menu/delete/{id}', [MenuController::class, 'delete']);
});


//
