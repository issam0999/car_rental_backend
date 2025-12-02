<?php

namespace App\Http\Resources;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'avatar' => $this->image ? $this->getImageUrl($this->image) : null,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'type_id' => $this->type_id,
            'type' => $this->getType(),
            'category' => 'Contact',
            'date_of_birth' => $this->date_of_birth,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'status' => $this->status === Contact::STATUS_ACTIVE,
            'connections' => $this->whenLoaded('connections', fn () => ContactConnectionResource::collection($this->connections)), // $this->connections,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
