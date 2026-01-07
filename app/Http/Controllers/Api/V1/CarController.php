<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use App\Http\Resources\CarResource;
use App\Http\Responses\ApiResponse;
use App\Models\Car;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Gate::authorize('viewAny', Contact::class);

        $user = $request->user();
        $query = Car::where('center_id', $user->center_id);

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
            if (in_array($status, ContactStatus::values())) {
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
        $params = [];

        if ($request->boolean('withParams')) {
            $params = Car::getParameters();
        }

        return ApiResponse::success(array_merge(
            [
                'items' => CarResource::collection($data),
                'total' => $data->total(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
            ],
            ['params' => $params],
        ),
            'Cars retrieved successfully'
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        $data = $request->validated();
        $data['center_id'] = $request->user()->center_id;

        $car = Car::create($data);

        if ($data['image_url']) {
            $image = FileHelper::saveBase64Image($request->image_url, "cars/{$car->center_id}");
            $data['image'] = $image;
        }

        return ApiResponse::success(new CarResource($car), 'Car created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        return ApiResponse::success(new CarResource($car), 'Car retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, Car $car)
    {
        $data = $request->validated();

        $car->update($data);

        if ($data['image_url']) {
            $image = FileHelper::saveBase64Image($request->image_url, "cars/{$car->center_id}");
            $data['image'] = $image;
        }

        return ApiResponse::success(new CarResource($car), 'Car updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getparameters(): JsonResponse
    {
        $params = Car::getParameters();

        return ApiResponse::success($params, 'Car parameters retrieved successfully');
    }
}
