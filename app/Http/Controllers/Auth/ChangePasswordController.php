<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class ChangePasswordController extends Controller
{
    /**
     * Handle password change request
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // Validate input
        $request->validate([
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'confirmed', Rules\password::defaults()], // new_password_confirmation

        ]);

        // Check current password
        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return ApiResponse::success(null, 'Password changed successfully.');
    }
}
