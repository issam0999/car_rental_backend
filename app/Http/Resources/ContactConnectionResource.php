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
            'connection_contact_id' => $this->connection_contact_id,
            'name' => $connectionContact->name,
            'avatar' => when($connectionContact->image, $connectionContact->getImageUrl($connectionContact->image)),
            'primary' => $this->is_primary,
        ];
    }
}
