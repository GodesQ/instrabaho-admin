<?php

namespace App\Http\Requests\Auth\API;

use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password' => ['required'],
            'profile_photo' => ['nullable'],
            'username' => ['required'],
            'country_code' => ['required', 'in:63'],
            'contact_number' => ['required', 'max:10'],
            'address' => ['required'],
            'latitude' => ['required_with:address'],
            'longitude' => ['required_with:address'],
        ];
    }
}
