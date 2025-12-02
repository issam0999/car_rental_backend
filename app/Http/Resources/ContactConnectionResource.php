<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactConnectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $connectionContact = $this->connectionContact;

        return [
            'id' => $this->id,
            'name' => $connectionContact->name,
            'avatar' => when($connectionContact->image, $connectionContact->getImageUrl($connectionContact->image)),
            'is_primary' => $this->is_primary,
        ];
    }
}
