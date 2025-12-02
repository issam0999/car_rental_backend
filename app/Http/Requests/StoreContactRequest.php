<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'center_id' => auth()->user()->center_id,
            'status' => 1,
        ]);
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
            'image' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'type_id' => 'nullable|integer',
            'date_of_birth' => 'nullable|date',
            'country_id' => 'nullable|integer',
            'city_id' => 'nullable|integer',
            'center_id' => 'exists:centers,id',
            'status' => 'nullable|boolean',
        ];
    }
}
