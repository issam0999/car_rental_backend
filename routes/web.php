<?php

use App\Models\User;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [Env::get('APP_NAME', 'Squarely') => '2.0.0'];
});

Route::get('/mailable', function () {
    $center = App\Models\Center::find(1);

    return new App\Mail\CenterCreated($center, User::find(1), 'secret123');
});

require __DIR__.'/auth.php';
