<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Http\Responses\ApiResponse;
use App\Models\Document;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'documentable_type' => 'required|string',
            'documentable_id' => 'required|integer',
        ]);

        $query = Document::where('documentable_type', $request->documentable_type)
            ->where('documentable_id', $request->documentable_id);

        // Search
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('number', 'like', "%{$request->q}%");
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

        // Sorting
        if ($request->filled('sortBy') && $request->filled('orderBy')) {
            $query->orderBy($request->sortBy, $request->orderBy);
        } else {
            $query->orderBy('id', 'desc');
        }

        // Paginate
        $data = $query->paginate($request->get('itemsPerPage', 15));

        return ApiResponse::success(
            [
                'items' => DocumentResource::collection($data),
                'total' => $data->total(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
            ],
            'Documents retrieved successfully'
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDocumentRequest $request)
    {
        try {
            $data = $request->validated();
            Log::info($data);

            $file = $request->file('file');
            Log::info(message: 'file '.$file);
            if ($file) {
                Log::info('inside');
                $folder = strtolower(class_basename($data['documentable_type']));

                // Store file
                $path = $file->store("documents/{$folder}", 'public');

                // Create document
                $document = Document::create([
                    'documentable_type' => $data['documentable_type'],
                    'documentable_id' => $data['documentable_id'],

                    'name' => $data['name'] ?? $file->getClientOriginalName(),
                    'number' => $data['number'],
                    'type_id' => $data['type_id'],
                    'issue_date' => $data['issue_date'],
                    'expiry_date' => $data['expiry_date'],
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            } else {
                $document = Document::create([
                    'documentable_type' => $data['documentable_type'],
                    'documentable_id' => $data['documentable_id'],

                    'type_id' => $data['type_id'],

                    'name' => $data['name'] ?? basename($data['url']),
                    'number' => $data['number'],
                    'issue_date' => $data['issue_date'],
                    'expiry_date' => $data['expiry_date'],
                    'external_link' => $data['url'],
                    'size' => 0,
                ]);
            }

            return ApiResponse::success($document, 'Document stored successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    public function parameters(): JsonResponse
    {
        $types = [
            ['value' => 1, 'title' => 'Contract'],
            ['value' => 2, 'title' => 'Passport'],
            ['value' => 3, 'title' => 'ID Card']]; // Future gets from centerparams crm_industries

        $data = [
            'statuses' => [],
            'types' => $types,
        ];

        return ApiResponse::success($data, 'Document parameters retrieved successfully');
    }
}
