<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
            'type_id' => $this->type_id,
            'number' => $this->number,
            'name' => $this->name,
            'expiry_date' => $this->expiry_date,
            'issue_date' => $this->issue_date,
            'external_link' => $this->external_link,
            // display
            'url' => $this->path,
            'status' => ['title' => $this->status, 'color' => 'success'],
        ];
    }
}
