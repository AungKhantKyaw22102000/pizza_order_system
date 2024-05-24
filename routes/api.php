<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// GET
Route::get('product/list',[RouteController::class, 'productList']);
Route::get('category/list',[RouteController::class, 'categoryList']);

// POST
Route::post('create/category',[RouteController::class, 'createCategory']);
Route::post('create/contact',[RouteController::class,'createContact']);

// DELETE
Route::post('delete/category',[RouteController::class, 'deleteCategory']);

/*
product list

product list
http://127.0.0.1:8000/api/product/list (GET)


category list
http://127.0.0.1:8000/api/category/list (Get)

create category
http://127.0.0.1:8000/api/list/category (Post)
*/
