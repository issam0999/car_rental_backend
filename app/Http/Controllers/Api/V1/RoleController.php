<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Role::with('permissions', 'users', 'users.contact')
            ->where('center_id', $request->user()->center_id);

        $permissions = Permission::getPermissionsWithModule();

        // Search
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%");
            });
        }

        // category filter
        if ($request->filled('permission')) {
            $query->whereHas('permissions', function ($q) use ($request) {
                $q->where('permission_id', $request->permission);
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

        return ApiResponse::success(array_merge(
            [
                'items' => RoleResource::collection($data),
                'total' => $data->total(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
                'permissions' => $permissions,
            ],
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $role = Role::create([
            'name' => $validated['name'],
            'center_id' => $request->user()->center_id,
            'guard_name' => 'api',
        ]);
        $role->syncPermissions($request->permissions);

        return ApiResponse::success(new RoleResource($role));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $role->update([
            'name' => $validated['name'],
        ]);
        $role->syncPermissions($request->permissions);

        return ApiResponse::success(new RoleResource($role));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return ApiResponse::success(['message' => 'Role deleted successfully']);
    }
}
