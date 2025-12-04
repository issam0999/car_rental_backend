<?php

namespace App\Http\Resources;

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
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'country' => [
                'name' => $this->country?->name,
                'city' => $this->city?->name,
            ],
            'type_id' => $this->type_id,
            'type' => $this->getType(),
            'categories' => ContactCategoryResource::collection($this->whenLoaded('categories')),
            'date_of_birth' => $this->date_of_birth,
            'status' => [
                'title' => $this->status->title(),
                'color' => $this->status->color(),
            ],
            'connections' => ContactConnectionResource::collection($this->whenLoaded('connections')),
            'sales_team_member' => $this->whenLoaded('salesteam') ? true : false,
            'sales_team' => new SalesTeamResouce($this->whenLoaded('salesteam')),
            'trn_number' => $this->tin_number,
            'vat_number' => $this->vat_number,
            'customer_ref_number' => $this->customer_ref_number,
            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
