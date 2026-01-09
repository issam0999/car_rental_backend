<?php

namespace App\Http\Resources;

use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            'image' => $this->image,
            'image_url' => $this->image ? FileHelper::getImageUrl($this->image) : null,
            'center_id' => $this->center_id,
            'category' => $this->category,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'color' => $this->color,
            'plate_number' => $this->plate_number,
            'seats' => $this->seats,
            'doors' => $this->doors,
            'transmission' => $this->transmission,
            'fuel_type' => $this->fuel_type,
            'mileage' => $this->mileage,
            'price_per_day' => $this->price_per_day,
            'price_per_week' => $this->price_per_week,
            'price_per_month' => $this->price_per_month,
            'minimum_rental_days' => $this->minimum_rental_days,
            'description' => $this->description,
            'status' => $this->status,
            'images' => ImageResource::collection($this->whenLoaded('images')),
            'status_info' => $this->status ? [
                'value' => $this->status,
                'title' => $this->status->title(),
                'color' => $this->status->color(),
            ] : null,
            'category_info' => $this->category ? [
                'value' => $this->category->value,
                'title' => $this->category->title(),
                'icon' => $this->category->icon(),
            ] : null,
            'available' => $this->status == 'available' ? true : false,
            'created_at' => $this->created_at,
        ];
    }
}
