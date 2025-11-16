<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;
use App\Http\Resources\PersonResource;
use App\Http\Responses\ApiResponse;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $persons = Person::where('center_id', $user->center_id)->paginate(10);

        return ApiResponse::success(
            PersonResource::collection($persons),
            'Persons retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {
        $data = $request->validated();

        $data['status'] = Person::STATUS_ACTIVE;

        $result = Person::create($data);

        return ApiResponse::success(new PersonResource($result), 'Person created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Person $person)
    {
        return ApiResponse::success(new PersonResource($person), 'Person retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, Person $person)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $relativePath = $person->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $person->update($data);

        return ApiResponse::success(new PersonResource($person), 'Person updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Person $person)
    {
        $person->update(['status' => Person::STATUS_DELETED]);

        return ApiResponse::success(null, 'Person deleted successfully');
    }
}
