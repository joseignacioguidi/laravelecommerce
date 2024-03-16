<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MercadoPagoController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('product',[ProductController::class,'getProducts']);
Route::get('product/{id}',[ProductController::class,'getProduct']);
Route::post('product',[ProductController::class,'createProduct']);
Route::put('product/{id}',[ProductController::class,'updateProduct']);
Route::delete('product/{id}',[ProductController::class,'deleteProduct']);

Route::get('category',[CategoryController::class,'getCategories']);
Route::get('category/{id}',[CategoryController::class,'getCategory']);
Route::post('category',[CategoryController::class,'createCategory']);
Route::put('category/{id}',[CategoryController::class,'updateCategory']);
Route::delete('category/{id}',[CategoryController::class,'deleteCategory']);

Route::post('buy',[MercadoPagoController::class,'generateLink']);
Route::post('buy/notification',[MercadoPagoController::class,'notification']);

Route::post('auth/register',[UserController::class,'register']);
Route::post('auth/login',[UserController::class,'login']);
Route::post('auth/logout',[UserController::class,'logout']);
