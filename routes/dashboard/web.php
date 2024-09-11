<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\ClientController;
use App\Http\Controllers\Dashboard\OrderController;


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){
            Route::get('/',[DashboardController::class,'index'])->name('index');



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


            //products routes
            Route::prefix('products')->name('products.')->group(function(){
                Route::get('/', [ProductController::class,'index'])->name('index');
                Route::get('edit/{id}', [ProductController::class,'edit'])->name('edit');
                Route::get('create', [ProductController::class,'create'])->name('create');
                Route::post('delete/{id}', [ProductController::class,'destroy'])->name('delete');
                Route::post('store', [ProductController::class,'store'])->name('store');
                Route::post('update/{id}', [ProductController::class,'update'])->name('update');
            });
            //end of products routes


            //clients routes
            Route::prefix('clients')->name('clients.')->group(function(){
                Route::get('/', [ClientController::class,'index'])->name('index');
                Route::get('edit/{id}', [ClientController::class,'edit'])->name('edit');
                Route::get('create', [ClientController::class,'create'])->name('create');
                Route::post('delete/{id}', [ClientController::class,'destroy'])->name('delete');
                Route::post('store', [ClientController::class,'store'])->name('store');
                Route::post('update/{id}', [ClientController::class,'update'])->name('update');
            });
            //end of clients routes


            //clients orders routes
            Route::prefix('clients/orders')->name('clients.orders.')->group(function(){
                Route::get('/', [OrderController::class,'index'])->name('index');
                Route::get('edit/{id}/{clientId}', [OrderController::class,'edit'])->name('edit');
                Route::get('create/{id}', [OrderController::class,'create'])->name('create');
//                Route::post('delete/{id}', [OrderController::class,'destroy'])->name('delete');
                Route::post('store/{id}', [OrderController::class,'store'])->name('store');
                Route::post('update/{orderId}/{clientId}', [OrderController::class,'update'])->name('update');
            });
            //end of clients orders routes


            // orders routes
            Route::prefix('orders')->name('orders.')->group(function(){
                Route::get('/', [OrderController::class,'index'])->name('index');
                Route::get('/orders/{id}/products', [OrderController::class,'getProductsPerOrder'])->name('products');
                Route::post('delete/{id}', [OrderController::class,'delete'])->name('delete');
            });
            //end of orders routes


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



        });
    });

