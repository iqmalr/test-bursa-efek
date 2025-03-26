<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);

    Route::get('category-products', [CategoryProductController::class, 'index']);
    Route::post('category-products', [CategoryProductController::class, 'store']);
    Route::get('category-products/{id}', [CategoryProductController::class, 'show']);
    Route::put('category-products/{id}', [CategoryProductController::class, 'update']);
    Route::delete('category-products/{id}', [CategoryProductController::class, 'destroy']);
    Route::patch('category-products/{id}/restore', [CategoryProductController::class, 'restore']);

    Route::get('products', [ProductController::class, 'index']);
    Route::post('products', [ProductController::class, 'store']);
    Route::get('products/{uuid}', [ProductController::class, 'show']);
    Route::put('products/{uuid}', [ProductController::class, 'update']);
    Route::delete('products/{uuid}', [ProductController::class, 'destroy']);
    Route::patch('products/{uuid}/restore', [ProductController::class, 'restore']);

    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
