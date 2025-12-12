<?php

namespace App\Http\Resources;

use App\Models\Document as ModelsDocument;
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
            'number' => $this->number ?? '',
            'name' => $this->name,
            'expiry_date' => $this->expiry_date,
            'issue_date' => $this->issue_date,
            'external_link' => $this->external_link,
            'note' => $this->note,
            'reminder' => $this->reminder,
            // display
            'url' => $this->path ?? $this->external_link,
            'status' => ModelsDocument::STATUS_ARR[0],
        ];
    }
}
