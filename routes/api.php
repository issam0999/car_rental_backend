<?php

use App\Http\Controllers\Api\V1\CenterController;
use App\Http\Controllers\Api\V1\CenterPackageController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\IndustryController;
use App\Http\Controllers\Api\V1\PersonController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum', 'verified')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('v1')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('people', PersonController::class);
        Route::apiResource('centers', CenterController::class);
        Route::apiResource('industries', IndustryController::class);
        Route::apiResource('center-packages', CenterPackageController::class);
        Route::apiResource('countries', CountryController::class);
    });
});
require __DIR__.'/auth.php';
