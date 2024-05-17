<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


// login , register
Route::redirect('/', 'loginPage');
Route::middleware(['admin_auth'])->group(function(){
    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {
    // dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');

    // admin
    Route::middleware(['admin_auth'])->group(function(){
        // category
        Route::prefix('category')->group(function(){
            Route::get('list', [CategoryController::class, 'list'])->name('category#list');
            Route::get('create/page',[CategoryController::class, 'createPage'])->name('category#createPage');
            Route::post('create',[CategoryController::class, 'create'])->name('category#create');
            Route::get('delete/{id}',[CategoryController::class, 'delete'])->name('category#delete');
            Route::get('edit/{id}',[CategoryController::class, 'edit'])->name('category#edit');
            Route::post('update',[CategoryController::class, 'update'])->name('category#update');
        });

        // admin account
        Route::prefix('admin')->group(function(){
            // password
            Route::get('password/changePage',[AdminController::class, 'changePasswordPage'])->name('admin#changePasswordPage');
            Route::post('change/password',[AdminController::class, 'changePassword'])->name('admin#changePassword');

            // account
            Route::get('details',[AdminController::class, 'details'])->name('admin#details');
            Route::get('edit',[AdminController::class, 'edit'])->name('admin#edit');
            Route::post('update{id}', [AdminController::class, 'update'])->name('admin#update');

        });
        // product
        Route::prefix('products')->group(function(){
            Route::get('list',[ProductController::class, 'list'])->name('product#list');
            Route::get('create',[ProductController::class, 'createPage'])->name('product#createPage');
            Route::post('create',[ProductController::class, 'create'])->name('product#create');
            Route::get('delete/{id}',[ProductController::class, 'delete'])->name('product#delete');
            Route::get('edit/{id}',[ProductController::class, 'edit'])->name('product#edit');
        });
    });


    // user
    // home
    Route::prefix('user')->middleware('user_auth')->group(function(){
        Route::get('home', function(){
            return view('user.home');
        })->name('user#home');
    });
});


// user
