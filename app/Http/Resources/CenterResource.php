<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CenterResource extends JsonResource
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
            'description' => $this->description,
            'location' => $this->location,
            'phone' => $this->phone,
            'phone1' => $this->phone1,
            'email' => $this->email,
            'email1' => $this->email1,
            'avatar' => $this->logo,
            'status' => $this->status,
            'created_at' => $this->created_at?->toDateString(),
            'package' => new CenterPackageResource($this->package),
            'industry' => new IndustryResource($this->industry),
        ];
    }
}
