<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->middleware('guest')
        ->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('guest')
        ->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('guest')
        ->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.store');

    Route::post('change-password', ChangePasswordController::class)
        ->middleware('auth:sanctum')->name('change-password');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:sanctum')
        ->name('logout');

    Route::post('/email/verification-notification', function (Request $request) {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Email is already verified.',
            ], 200);
        }

        $link = $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Verification link sent successfully.',
        ], 200);
    })
        ->middleware(['auth:sanctum', 'throttle:6,1'])
        ->name('verification.send');

    // Verify Email
    Route::get('/verify-email/{id}/{hash}', function (Request $request) {
        $user = User::find($request->route('id'));

        if (! $user) {
            Log::error('User not found for email verification', ['id' => $request->route('id')]);
            abort(404, 'User not found.');
        }

        Log::info('Verifying user', ['id' => $user->id, 'email' => $user->email]);

        if (! hash_equals((string) $request->route('hash'),
            sha1($user->getEmailForVerification()))) {
            Log::error('Invalid hash for email verification', [
                'expected' => sha1($user->getEmailForVerification()),
                'given' => $request->route('hash'),
            ]);
            abort(403, 'Invalid verification link.');
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'Email already verified.']);
        }

        $user->markEmailAsVerified();
        Log::info(message: 'Email verified successfully');

        return response()->json(['message' => 'Email verified successfully.']);
    })
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});
