<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\ContactStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\ContactCategoryResource;
use App\Http\Resources\ContactConnectionResource;
use App\Http\Resources\ContactResource;
use App\Http\Responses\ApiResponse;
use App\Models\Contact;
use App\Models\ContactCategory;
use App\Models\ContactConnection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Contact::class);

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
        Gate::authorize('create', Contact::class);

        $data = $request->validated();

        if (! empty($data['email'] || ! empty($data['phone'])) &&
        empty($request->boolean('force_create')) &&
        Contact::where('email', $data['email'])->orWhere('phone', $data['phone'])->exists()
        ) {
            return response()->json([
                'message' => 'Email or phone already exists. Do you want to continue?',
                'code' => 'EMAIL_EXISTS',
            ], 409);
        }

        $data['status'] = ContactStatus::Active;

        $result = Contact::create($data);

        return ApiResponse::success(new ContactResource($result), 'Contact created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        Gate::authorize('view', $contact);

        $contact->load('categories', 'connections', 'connections.connectionContact', 'connections.contact', 'salesteam');

        return ApiResponse::success(new ContactResource($contact), 'Contact retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        Gate::authorize('update', $contact);

        try {
            $data = $request->validated();
            Log::info($data);
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
            $contact->load('categories');

            return ApiResponse::success(new ContactResource($contact), 'Contact updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return ApiResponse::error($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        Gate::authorize('delete', $contact);

        $contact->delete();

        return ApiResponse::success(null, 'Contact deleted successfully');
    }

    public function list(): Collection
    {
        return Contact::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
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

        $data = ['categories' => ContactCategoryResource::collection($categories),
            'statuses' => $statuses,
        ];

        return ApiResponse::success($data, 'Contact parameters retrieved successfully');
    }

    public function addConnections(Contact $contact, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'connections' => 'required|array',
            'connections.*.connection_contact_id' => 'required',
            'connections.*.relation' => 'nullable|string|max:255',
            'connections.*.primary' => 'boolean',
        ]);
        $isPrimary = false;

        foreach ($validated['connections'] as $conn) {
            if ($conn['primary'] && ! $isPrimary) {
                ContactConnection::where('contact_id', $contact->id)->update(['is_primary' => false]);
                $isPrimary = true;
            }
            ContactConnection::firstOrCreate(
                [
                    'contact_id' => $contact->id,
                    'connection_contact_id' => $conn['connection_contact_id'],
                ],
                [
                    'relation' => $conn['relation'],
                    'is_primary' => $isPrimary,
                ]
            );
        }
        $connections = ContactConnectionResource::collection($contact->connections()->get());

        return ApiResponse::success($connections, 'Connections added successfully');
    }

    public function updateConnection(ContactConnection $connection, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'relation' => 'nullable|string|max:255',
            'primary' => 'boolean',
        ]);

        $connection->update($validated);

        return ApiResponse::success(new ContactConnectionResource($connection), 'Connection updated successfully');
    }

    public function deleteConnection(ContactConnection $connection, Request $request): JsonResponse
    {
        $connection->delete();

        return ApiResponse::success(null, 'Connection deleted successfully');
    }
}
