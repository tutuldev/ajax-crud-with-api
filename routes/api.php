<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('signup',[AuthController::class, 'signup']);
Route::post('login',[AuthController::class, 'login']);

// group api Middleware route
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout',[AuthController::class, 'logout']);
    Route::apiResource('posts',PostController::class);

});
