<?php

namespace App\Http\Requests;

use App\Enums\ContactStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
            'date_of_birth' => 'nullable|date',
            'country_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'type_id' => 'nullable|integer',
            'status_id' => ['nullable', new Enum(ContactStatus::class)],
            'image' => 'nullable|string', // base64 string, optional
            'sales_team_member' => 'nullable|boolean',
            'category_ids' => 'nullable|array',
            'category.*' => 'integer|exists:contact_categories,id',
            'industry_id' => 'nullable|integer',
            'description' => 'nullable|string|max:1000',
            'customer_ref_number' => 'nullable|string|max:255',
            'tin_number' => 'nullable|string|max:255',
            'vat_number' => 'nullable|numeric',
            'channel_id' => 'nullable|integer',
            'website' => 'nullable|string|max:255',
            'language_id' => 'nullable|integer',
        ];
    }
}
