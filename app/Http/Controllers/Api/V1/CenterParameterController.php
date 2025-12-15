<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CenterParameterResource;
use App\Http\Responses\ApiResponse;
use App\Models\CenterParameter;
use Illuminate\Http\Request;

class CenterParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = [];

        $groups = CenterParameter::with('values')->get()->groupBy('group');

        foreach ($groups as $groupName => $items) {
            $params[$groupName] = [];

            foreach ($items as $item) {
                $params[$groupName][$item->key] = (new CenterParameterResource($item))
                    ->resolve($request);
            }
        }

        return ApiResponse::success($params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
