<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::prefix('dashboard')->name('dashboard.')->group(function(){
            Route::get('/',[DashboardController::class,'index'])->name('index');
            Route::get('/users', [UserController::class,'index'])->name('users');
            Route::get('/users/edit/{id}', [UserController::class,'edit'])->name('users.edit');
            Route::get('/users/create', [UserController::class,'create'])->name('users.create');
            Route::post('/users/delete/{id}', [UserController::class,'destroy'])->name('users.delete');
            Route::post('/users/store', [UserController::class,'store'])->name('users.store');

        });
    });

