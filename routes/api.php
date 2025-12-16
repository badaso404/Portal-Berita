<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('news')->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\NewsController::class, 'index']);
    Route::get('/search', [\App\Http\Controllers\Api\NewsController::class, 'search']);
    Route::get('/category/{slug}', [\App\Http\Controllers\Api\NewsController::class, 'category']);
    Route::get('/{id}', [\App\Http\Controllers\Api\NewsController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->prefix('admin')->group(function () {
    Route::post('/news', [\App\Http\Controllers\Api\Admin\NewsController::class, 'store']);
    Route::put('/news/{id}', [\App\Http\Controllers\Api\Admin\NewsController::class, 'update']);
    Route::delete('/news/{id}', [\App\Http\Controllers\Api\Admin\NewsController::class, 'destroy']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
