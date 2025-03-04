<?php

namespace App\Http\Requests\APIConsumer;

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
            'app_name' => ['required', 'max:150'],
            'platform' => ['required', 'array'],
            'contact_email' => ['required', 'email'],
            'contact_phone' => ['required', 'max:12']
        ];
    }
}
