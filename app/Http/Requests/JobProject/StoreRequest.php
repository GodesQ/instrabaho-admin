<?php

namespace App\Http\Requests\JobProject;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "creator_id" => ["required"],
            "service_id" => ["required",],
            "transaction_type" => ["required", "in:fixed,hourly"],
            "price_amount" => ["required", "numeric"],
            "address" => ["required"],
            "latitude" => ["required_with:address"],
            "longitude" => ["required_with:address"],
            "instructions" => ["required"],
            "notes" => ["nullable"],
            "job_attachments" => ["nullable", "array"],
            "status" => ["required", "in:drafted,pending,published,blocked"],
        ];
    }

    public function messages(): array
    {
        return [
            'creator_id.required' => 'The customer field is required.',
            'service_id.required' => 'The service field is required.',
        ];
    }
}
