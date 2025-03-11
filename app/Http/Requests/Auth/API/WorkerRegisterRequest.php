<?php

namespace App\Http\Requests\Auth\API;

use Illuminate\Foundation\Http\FormRequest;

class WorkerRegisterRequest extends FormRequest
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
            'first_name' => ['required', 'max:50'],
            'last_name' => ['required', 'max:50'],
            'middle_name' => ['nullable', 'max:50'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'country_code' => ['required'],
            'contact_number' => ['required', 'max:10', 'unique:workers,contact_number'],
            'gender' => ['required', 'in:Male,Female'],
            'address' => ['required'],
            'latitude' => ['required_with:address'],
            'longitude' => ['required_with:address'],
            'identification_file' => ['required', 'max:50'],
            'nbi_copy_file' => ['required', 'max:50'],
            'service_id' => ['required', 'max:50', 'exists:services,id'],
        ];
    }
}
