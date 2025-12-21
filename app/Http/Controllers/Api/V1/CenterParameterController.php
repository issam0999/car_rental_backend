<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\CenterParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CenterParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return ApiResponse::success(CenterParameter::getAll($request));
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
        try {

            foreach ($request->all() as $key => $value) {

                $param = CenterParameter::where('key', $key)->with('values')->first();

                if (! $param) {
                    continue;
                }

                // 👉 MULTISELECT
                if ($param->type === 'multiselect') {
                    $param->syncMultiselect($value);

                    continue;
                }

                // 👉 NORMAL VALUE
                $param->value = $value;
                $param->save();
            }

            return ApiResponse::success(CenterParameter::getAll($request));
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
