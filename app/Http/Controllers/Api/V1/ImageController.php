<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Responses\ApiResponse;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imageable_type' => 'required|string',
            'imageable_id' => 'required|integer',
            'images.*' => 'image|max:4096',
        ]);
        $centerId = $request->user()->center_id;

        $modelClass = Image::getImageableModels($request->imageable_type);

        if (! $modelClass) {
            abort(400, 'Invalid imageable type');
        }

        $model = $modelClass::findOrFail($request->imageable_id);

        foreach ($request->file('images', []) as $file) {
            $path = $file->store("images/{$centerId}/{$request->imageable_type}/{$model->id}", 'public');

            $model->images()->create([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
            ]);
        }

        return ApiResponse::success(ImageResource::collection($model->images), 'Images uploaded successfully');
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
