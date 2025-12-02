<?php

namespace App\Http\Resources;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'verified' => (bool) $this->email_verified_at,
            'created_at' => $this->created_at?->toDateTimeString(),
            'status' => $this->status,
            'center' => $this->center,
            'role' => 'admin',
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'report_to' => Contact::select(['id', 'name', 'image'])->where('id', 1)->get()->toArray(),
        ];
    }
}
