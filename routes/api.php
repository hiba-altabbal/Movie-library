<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/
Route::apiResource('Movies',MovieController::class);
Route::apiResource('Ratings',RatingController::class);
Route::apiResource('Users',UserController::class);