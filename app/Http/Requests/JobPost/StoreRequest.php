<?php

namespace App\Http\Requests\JobPost;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return true;
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
            "address" => ["required"],
            "latitude" => ["required_with:address"],
            "longitude" => ["required_with:address"],
            "description" => ["required"],
            "notes" => ["nullable"],
            "job_attachments" => ["nullable", "array"],
            "job_attachments.*" => ['file', 'max:3072'],
            "urgency" => ["required", "in:book_now,scheduled"],
            "scheduled_date" => ["nullable", "required_if:urgency,scheduled", "date_format:Y-m-d"],
            "scheduled_time" => ["nullable", "required_if:urgency,scheduled", "date_format:H:i"],
            "job_duration" => ["required_if:transaction_type,hourly"],
            "status" => ["required", "in:pending,published,blocked"],
        ];
    }

    public function messages(): array
    {
        return [
            'creator_id.required' => 'The client field is required.',
            'service_id.required' => 'The service field is required.'
        ];
    }
}
