<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\HomeController;
use App\Http\Controllers\Backend\UserController;










// Backend



Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', [UserController::class, 'loginForm'])->name('admin.login');
    Route::post('/login-form-post', [UserController::class, 'loginPost'])->name('admin.login.post');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');
        Route::get('/admin/logout', [UserController::class, 'logout'])->name('admin.logout');
    });
});
