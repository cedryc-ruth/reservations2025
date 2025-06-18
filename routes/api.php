<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistApiController;
use App\Http\Controllers\ShowApiController;
use App\Http\Controllers\LocationApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::apiResource('artists', ArtistApiController::class);
Route::apiResource('shows', ShowApiController::class);
Route::apiResource('locations', LocationApiController::class);