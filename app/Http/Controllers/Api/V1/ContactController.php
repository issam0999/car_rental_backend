<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Http\Responses\ApiResponse;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Contact::where('center_id', $user->center_id)->with('connections', 'connections.connectionContact', 'connections.contact');

        // Search
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%");
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $arr = ['active' => 1, 'suspended' => 0];
            $query->where('status', $arr[$request->status]);
        }

        // type filter
        if ($request->filled('type')) {
            $query->where('type_id', $request->type_id);
        }

        // category filter
        if ($request->filled('categoryId')) {
            $query->where('category_id', $request->categoryId);
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
                'items' => ContactResource::collection($data),
                'total' => $data->total(),
                'currentPage' => $data->currentPage(),
                'lastPage' => $data->lastPage(),
            ],
            'Contats retrieved successfully'
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        $data = $request->validated();

        $data['status'] = Contact::STATUS_ACTIVE;

        $result = Contact::create($data);

        return ApiResponse::success(new ContactResource($result), 'Contact created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return ApiResponse::success(new ContactResource($contact), 'Contact retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            $relativePath = $contact->saveImage($data['image']);
            $data['image'] = $relativePath;
        }

        $contact->update($data);

        return ApiResponse::success(new ContactResource($contact), 'Contact updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->update(['status' => Contact::STATUS_DELETED]);

        return ApiResponse::success(null, 'Contact deleted successfully');
    }
}
