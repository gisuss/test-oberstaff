<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->middleware('loginVerify');
    Route::post('register', [App\Http\Controllers\Users\UserController::class, 'store'])->middleware('registerVerify');
    
    Route::group( ['middleware' => ['auth:sanctum']], function() {
        Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
    });
});

Route::group( ['middleware' => ['auth:sanctum']], function() {
    Route::group(['prefix' => 'customers'], function () {
        Route::get('index', [App\Http\Controllers\Users\UserController::class, 'index'])->middleware('searchesVerify');
        Route::get('show/{search}', [App\Http\Controllers\Users\UserController::class, 'show'])->middleware('searchesVerify');
        Route::delete('delete/{search}', [App\Http\Controllers\Users\UserController::class, 'destroy'])->middleware('searchesVerify');
    });
    Route::group(['prefix' => 'logs'], function () {
        Route::get('index', [App\Http\Controllers\Logs\LogController::class, 'index'])->middleware('searchesVerify');
    });
});
