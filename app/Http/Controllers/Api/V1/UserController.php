<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize(ability: 'admin');

        // do not put center clause in user boot
        $query = User::where('center_id', operator: $request->user()->center_id)->with('contact', 'roles');
        // Search
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $status = $request->status;
            if (in_array($status, UserStatus::values())) {
                $query->where('status', $status);
            }
        }

        // type filter
        if ($request->filled('type')) {
            $query->where('type_id', $request->typeId);
        }

        // category filter
        if ($request->filled('categoryId')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('category_id', $request->categoryId);
            });
        }

        // Sorting
        if ($request->filled('sortBy') && $request->filled('orderBy')) {
            $query->orderBy($request->sortBy, $request->orderBy);
        } else {
            $query->orderBy('id', 'desc');
        }

        // Paginate
        $data = $query->paginate($request->get('itemsPerPage', 15));

        $params = null;

        if ($request->boolean('withParams')) {
            $statuses = collect(UserStatus::cases())->map(fn ($status) => [
                'value' => $status->value,
                'title' => $status->title(),
                'color' => $status->color(),
            ]);

            $params = [
                'statuses' => $statuses,
            ];
        }

        return ApiResponse::success(array_merge(
            [
                'items' => UserResource::collection($data),
                'total' => $data->total(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
            ],
            $params ? ['params' => $params] : []
        ));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('admin', User::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'roles' => 'required|exists:roles,name',
        ]);
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'roles' => $validated['roles'],
        ];
        $user = User::createNew($data);

        return ApiResponse::success(new UserResource($user), 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('contact', 'center', 'roles', 'contact.country');

        return ApiResponse::success(new UserResource($user), 'User retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => ['sometimes', 'email', Rule::unique('users')->ignore($user->id)],
                'password' => 'nullable|string|min:6',
                'status' => ['sometimes', Rule::enum(UserStatus::class)],
                'roles' => 'sometimes|exists:roles,name',

            ]);

            if (! empty($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            if ($request->filled('roles')) {
                $user->syncRoles($request->roles);
            }

            $user->load('contact');

            return ApiResponse::success(new UserResource($user), 'User updated successfully');

        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize(ability: 'admin');

        $user->delete();

        return ApiResponse::success(['message' => 'User deleted successfully']);
    }
}
