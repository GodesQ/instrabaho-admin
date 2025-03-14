<?php

namespace App\Http\Requests\Worker;

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
            "first_name" => ["required", "max:50"],
            "last_name" => ["required", "max:50"],
            "middle_name" => ["nullable", "max:50"],
            "username" => ["required", "max:20", "regex:/^\S*$/"],
            "email" => ["required", "email"],
            "country_code" => ["required"],
            "contact_number" => ["required", "max:10"],
            "gender" => ["nullable", "in:Male,Female,Other"],
            "birthdate" => ["nullable", "date"],
            "address" => ["required"],
            "latitude" => ["required_with:address"],
            "longitude" => ["required_with:address"],
            "hourly_rate" => ["required", "numeric"],
            "personal_description" => ["nullable", "max:1000"],
            "identification_file" => ["required", "file"],
            "service_id" => ["required", "exists:services,id"],
            "service_hourly_rate" => ["nullable", "numeric"],
        ];
    }
}
