<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
            'file' => 'required|file|max:2048,mimetypes:application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'type_id' => 'required|integer',
            'number' => 'required|string|max:255',
            'expiry_date' => 'nullable|date',
            'issue_date' => 'nullable|date',
            'documentable_type' => 'required|string', // e.g. App\Models\Contact
            'documentable_id' => 'required|integer',
            'external_link' => 'nullable|string|max:500',

        ];
    }
}
