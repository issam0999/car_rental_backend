<?php

use App\Http\Controllers\Api\V1\CenterController;
use App\Http\Controllers\Api\V1\CenterPackageController;
use App\Http\Controllers\Api\V1\CenterParameterController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\v1\DocumentController;
use App\Http\Controllers\Api\V1\EmailTemplateController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
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
        Route::apiResource('centers', CenterController::class);
        Route::apiResource('center-packages', CenterPackageController::class);
        Route::apiResource('countries', CountryController::class);
        Route::get('documents/parameters', [documentController::class, 'parameters']);
        Route::apiResource('documents', DocumentController::class);
        Route::apiResource('parameters', CenterParameterController::class);
        Route::apiResource('email-templates', EmailTemplateController::class);
        Route::apiResource('roles', RoleController::class)->middleware('can:admin');

        // Contact
        Route::middleware('permission:contact.view')->group(function () {
            Route::get('/contacts', [ContactController::class, 'index']);
            Route::get('/contacts/{contact}', [ContactController::class, 'show']);
        });

        Route::middleware('permission:contact.write')->group(function () {
            Route::post('/contacts', [ContactController::class, 'store']);
            Route::put('/contacts/{contact}', [ContactController::class, 'update']);
            Route::patch('/contacts/{contact}', [ContactController::class, 'update']);
        });

        Route::middleware('permission:contact.delete')->group(function () {
            Route::delete('/contacts/{contact}', [ContactController::class, 'destroy']);
        });

    });
});

require __DIR__.'/auth.php';
