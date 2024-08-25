<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){
            Route::get('/',[DashboardController::class,'index'])->name('index');

            //users routes
            Route::prefix('users')->name('users.')->group(function(){
                Route::get('/', [UserController::class,'index'])->name('index');
                Route::get('edit/{id}', [UserController::class,'edit'])->name('edit');
                Route::get('create', [UserController::class,'create'])->name('create');
                Route::post('delete/{id}', [UserController::class,'destroy'])->name('delete');
                Route::post('store', [UserController::class,'store'])->name('store');
                Route::post('update/{id}', [UserController::class,'update'])->name('update');
            });
            //end of users routes


            //categories routes
            Route::prefix('categories')->name('categories.')->group(function(){
                Route::get('/', [CategoryController::class,'index'])->name('index');
                Route::get('edit/{id}', [CategoryController::class,'edit'])->name('edit');
                Route::get('create', [CategoryController::class,'create'])->name('create');
                Route::post('delete/{id}', [CategoryController::class,'destroy'])->name('delete');
                Route::post('store', [CategoryController::class,'store'])->name('store');
                Route::post('update/{id}', [CategoryController::class,'update'])->name('update');
            });
            //end of categories routes


            //categories routes
            Route::prefix('products')->name('products.')->group(function(){
                Route::get('/', [ProductController::class,'index'])->name('index');
                Route::get('edit/{id}', [CategoryController::class,'edit'])->name('edit');
                Route::get('create', [ProductController::class,'create'])->name('create');
                Route::post('delete/{id}', [ProductController::class,'destroy'])->name('delete');
                Route::post('store', [ProductController::class,'store'])->name('store');
                Route::post('update/{id}', [ProductController::class,'update'])->name('update');
            });
            //end of categories routes


        });
    });

