<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Common;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailTemplateResource;
use App\Http\Responses\ApiResponse;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EmailTemplate::with('center', 'type');

        // Search
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('subject', 'like', "%{$request->q}%");
            });
        }

        // type filter
        if ($request->filled('typeId')) {
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
                'items' => EmailTemplateResource::collection($data),
                'total' => $data->total(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
            ],
            'Templates retrieved successfully'
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type_id' => 'required|integer|exists:center_parameter_values,id',
        ]);
        $data['center_id'] = Common::centerId();

        $template = EmailTemplate::create($data);
        $template->load('type');

        return ApiResponse::success(new EmailTemplateResource($template), 'Template created successfully');
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
    public function update(Request $request, EmailTemplate $emailTemplate)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type_id' => 'required|integer|exists:center_parameter_values,id',
        ]);

        $emailTemplate->update($data);
        $emailTemplate->load('type');

        return ApiResponse::success(new EmailTemplateResource($emailTemplate), 'Template updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return ApiResponse::success(null, 'Template deleted successfully');
    }
}
