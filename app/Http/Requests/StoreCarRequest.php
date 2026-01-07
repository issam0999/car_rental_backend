<?php

namespace App\Http\Requests;

use App\Enums\CarCategories;
use App\Enums\CarFuelTypes;
use App\Enums\CarStatuses;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => ['sometimes', Rule::enum(CarCategories::class)],
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:2000|max:'.date('Y'),
            'color' => 'required|string|max:100',
            'plate_number' => 'nullable|string|max:20|unique:cars,plate_number',
            'seats' => 'required|integer|min:2|max:10',
            'doors' => 'required|integer|min:2|max:5',
            'transmission' => 'nullable|string|in:manual,automatic',
            'fuel_type' => ['sometimes', Rule::enum(CarFuelTypes::class)],
            'mileage' => 'nullable|integer|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'price_per_week' => 'nullable|numeric|min:0',
            'price_per_month' => 'nullable|numeric|min:0',
            'minimum_rental_days' => 'required|integer|min:1|max:30',
            'status' => ['required', Rule::enum(CarStatuses::class)],
            'description' => 'nullable|string|max:1000',
            'center_id' => 'nullable|exists:centers,id',
            'image' => 'nullable|image|max:2048', // max 2MB
            'available' => 'required|boolean',
        ];
    }
}
