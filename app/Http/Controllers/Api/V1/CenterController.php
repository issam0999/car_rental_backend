<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CenterResource;
use App\Http\Responses\ApiResponse;
use App\Mail\CenterCreatedMail;
use App\Models\Center;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\JsonResponse;

class CenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centers = Center::with(['industry:id,name'], ['package:id,name'])->get();

        return ApiResponse::success(
            CenterResource::collection($centers),
            'Centers retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:centers,email',
                'description' => 'string|max:255|nullable',
                'subscription_type' => 'integer',
                'industry' => 'integer',
            ]);

            $center = Center::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'description' => $validated['description'] || '',
                'subscription_type' => 1,
            ]);

            User::CreateNew([
                'name' => 'Admin for '.$center->name,
                'email' => $center->email,
                'center_id' => $center->id,
                'password' => Str::password(),
            ]);
            DB::commit();

            // Send email
            Mail::to($center->email)
                ->queue(new CenterCreatedMail($request->user(), $center));

            return ApiResponse::success(
                new CenterResource($center),
                'Center created successfully'
            );
        } catch (\Throwable $e) {
            DB::rollBack();

            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Center $center)
    {
        $center->load(['industry:id,name', 'package:id,name']);

        return ApiResponse::success(new CenterResource($center), 'Center retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
