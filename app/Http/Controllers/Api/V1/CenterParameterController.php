<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\CenterParameterResource;
use App\Http\Responses\ApiResponse;
use App\Models\CenterParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CenterParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $centerId = Common::centerId();
        $cacheKey = "center_parameters_center_{$centerId}";

        $params = Cache::rememberForever($cacheKey, function () use ($request) {

            $result = [];
            $groups = CenterParameter::with('values')->get()->groupBy('group');

            foreach ($groups as $groupName => $items) {
                $result[$groupName] = [];

                foreach ($items as $item) {
                    $result[$groupName][$item->key] = (new CenterParameterResource($item))
                        ->resolve($request);
                }
            }

            return $result;
        });

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
