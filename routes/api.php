<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryProductController;
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

    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
