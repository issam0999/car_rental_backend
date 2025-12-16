<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CenterParameterResource extends JsonResource
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
            'value' => $this->type === 'multiselect' ? CenterParameterValueResource::collection($this->values) : $this->value,
            'hint' => $this->description,
            'required' => (bool) $this->required,
            'type' => $this->type,
        ];
    }
}
