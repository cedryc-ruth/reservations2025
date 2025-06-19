<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArtistApiController;
use App\Http\Controllers\ShowApiController;
use App\Http\Controllers\LocationApiController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

Route::apiResource('artists', ArtistApiController::class)->middleware('auth.basic');
Route::apiResource('shows', ShowApiController::class)->middleware('auth.basic');
Route::apiResource('locations', LocationApiController::class)->middleware('auth.basic');