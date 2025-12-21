<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CenterResource;
use App\Http\Responses\ApiResponse;
use App\Mail\CenterCreated;
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
    public function index(Request $request): JsonResponse
    {
        $query = Center::with('industry', 'package');

        // Search
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('location', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $arr = ['active' => 1, 'suspended' => 0];
            $query->where('status', $arr[$request->status]);
        }

        // Industry filter
        if ($request->filled('industry')) {
            $query->where('industry_id', $request->industry);
        }

        // Package filter
        if ($request->filled('package')) {
            $query->where('subscription_type', $request->package);
        }

        // Sorting
        if ($request->filled('sortBy') && $request->filled('orderBy')) {
            $query->orderBy($request->sortBy, $request->orderBy);
        }

        // Paginate
        $data = $query->paginate($request->get('itemsPerPage', 15));

        return ApiResponse::success(
            [
                'items' => CenterResource::collection($data),
                'total' => $data->total(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
            ],
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
                'subscription_type' => 'integer|exists:center_packages,id',
            ]);

            $center = Center::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'description' => $validated['description'] || '',
                'subscription_type' => $validated['subscription_type'],
            ]);

            $password = Str::password();
            User::CreateNew([
                'name' => 'Admin for '.$center->name,
                'email' => $center->email,
                'center_id' => $center->id,
                'password' => $password,
            ]);
            DB::commit();

            // Send email
            Mail::to($center->email)->queue(new CenterCreated($center->load('package'), $request->user(), $password));

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
        $center->load(['industry', 'package:id,name']);

        return ApiResponse::success(new CenterResource($center), 'Center retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Center $center)
    {
        $center->update($request->all());

        return ApiResponse::success(new CenterResource($center), 'Center updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
