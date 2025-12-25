<?php

namespace App\Http\Resources;

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
            'email' => $this->email,
            'position' => '', // from employee
            'verified' => (bool) $this->email_verified_at,
            'created_at' => $this->created_at?->toDateTimeString(),
            'status' => [
                'value' => $this->status?->value,
                'title' => $this->status?->title(),
                'color' => $this->status?->color(),
            ],
            'center' => $this->center,
            'role' => ['name' => 'admin', 'color' => 'primary', 'icon' => 'tabler-device-laptop'],
            'contact' => new ContactResource($this->whenLoaded('contact')),
            'report_to' => [], // from employee later
        ];
    }
}
