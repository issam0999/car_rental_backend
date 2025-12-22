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
            'category_ids' => $this->whenLoaded('categories', fn () => $this->categories->pluck('id')->toArray()),
            'type_id' => $this->type_id,
            'industry_id' => $this->industry_id,
            'channel_id' => $this->channel_id,
            'date_of_birth' => $this->date_of_birth,
            'status_id' => $this->status,
            'trn_number' => $this->tin_number,
            'vat_number' => $this->vat_number,
            'customer_ref_number' => $this->customer_ref_number,
            'website' => $this->website,
            'language_id' => $this->language_id,
            // display
            'country' => [
                'name' => $this->country?->name,
                'city' => $this->city?->name,
            ],
            'type' => $this->getType(),
            'categories' => ContactCategoryResource::collection($this->whenLoaded('categories')),

            'status' => [
                'title' => $this->status?->title(),
                'color' => $this->status?->color(),
            ],
            'connections' => ContactConnectionResource::collection($this->whenLoaded('connections')),
            'sales_team_member' => $this->whenLoaded('salesteam') ? true : false,
            'sales_team' => new SalesTeamResouce($this->whenLoaded('salesteam')),

            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
