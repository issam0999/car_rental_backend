<?php

use App\Http\Controllers\Api\V1\CenterController;
use App\Http\Controllers\Api\V1\CenterPackageController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\IndustryController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum', 'verified')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('v1')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::get('contacts/parameters', [ContactController::class, 'parameters']);
        Route::get('/contacts/list', [ContactController::class, 'list']);
        Route::post('/contacts/{contact}/add-connections', [ContactController::class, 'addConnections']);
        Route::post('/contacts/update-connection/{connection}', [ContactController::class, 'updateConnection']);
        Route::post('/contacts/delete-connection/{connection}', [ContactController::class, 'deleteConnection']);
        Route::apiResource('contacts', ContactController::class);
        Route::apiResource('centers', CenterController::class);
        Route::apiResource('industries', IndustryController::class);
        Route::apiResource('center-packages', CenterPackageController::class);
        Route::apiResource('countries', CountryController::class);
    });
});

require __DIR__.'/auth.php';
