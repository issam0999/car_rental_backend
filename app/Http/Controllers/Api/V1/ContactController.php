<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ContactStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactCategoryResource;
use App\Http\Resources\ContactResource;
use App\Http\Responses\ApiResponse;
use App\Models\Contact;
use App\Models\ContactCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Contact::where('center_id', $user->center_id)->with('categories', 'connections', 'connections.connectionContact', 'connections.contact');

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

        $data['status'] = ContactStatus::Active;

        $result = Contact::create($data);

        return ApiResponse::success(new ContactResource($result), 'Contact created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        $contact->load('categories', 'connections', 'connections.connectionContact', 'connections.contact', 'salesteam');

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

        // sync categories
        $contact->categories()->sync($data['category_ids'] ?? []);

        if (! empty($data['sales_team_member'])) {
            $contact->salesTeam()->updateOrCreate([], ['center_id' => $contact->center_id]);
        } else {
            $contact->salesTeam()->delete();
        }

        return ApiResponse::success(new ContactResource($contact), 'Contact updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // $contact->update(['status' => Contact::STATUS_DELETED]);

        return ApiResponse::success(null, 'Contact deleted successfully');
    }

    /**
     * Retrieves contact parameters like Statuses and Categories.
     */
    public function parameters(): JsonResponse
    {
        $categories = ContactCategory::all();
        $statuses = collect(ContactStatus::cases())->map(fn ($status) => [
            'value' => $status->value,
            'title' => $status->title(),
            'color' => $status->color(),
        ]);
        $industries = [
            ['value' => 1, 'title' => 'General'],
            ['value' => 2, 'title' => 'VIP'],
            ['value' => 3, 'title' => 'Real Estate']]; // Future gets from centerparams crm_industries

        $channels = [
            ['value' => 1, 'title' => 'Social Media'],
            ['value' => 2, 'title' => 'Referral'],
            ['value' => 3, 'title' => 'Direct Sales']]; // Future gets from centerparams crm_channels
        $data = ['categories' => ContactCategoryResource::collection($categories),
            'statuses' => $statuses,
            'industries' => $industries,
            'channels' => $channels,
        ];

        return ApiResponse::success($data, 'Contact parameters retrieved successfully');
    }
}
