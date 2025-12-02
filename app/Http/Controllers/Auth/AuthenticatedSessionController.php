<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->authenticate();

        $user = Auth::user();

        if (! $user->hasVerifiedEmail()) {
            Auth::logout();

            throw new \Exception('Your email address is not verified.');
        }

        $user->load('contact');

        $token = $user->createToken('main')->plainTextToken;

        return ApiResponse::success([
            'user' => new UserResource($user),
            'token' => $token,
            'userAbilityRules' => 'admin',
        ], 'Logged in successfully');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->noContent();
    }
}
