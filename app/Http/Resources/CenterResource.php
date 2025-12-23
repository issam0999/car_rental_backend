<?php

namespace App\Http\Resources;

use App\Helpers\FileHelper;
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
            'image' => $this->logo,
            'image_url' => $this->logo ? FileHelper::getImageUrl($this->logo) : null,
            'name' => $this->name,
            'description' => $this->description,
            'phone' => $this->phone,
            'phone1' => $this->phone1,
            'email' => $this->email,
            'email1' => $this->email1,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'industry_id' => $this->industry_id,
            // display
            'status' => $this->status ? 'active' : 'inactive',
            'created_at' => $this->created_at?->toDateString(),
            'package' => new CenterPackageResource($this->package),
            'country' => new CountryResource($this->country),
            'industry' => new CenterParameterValueResource($this->industry),
        ];
    }
}
