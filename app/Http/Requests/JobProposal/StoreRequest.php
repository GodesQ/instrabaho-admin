<?php

namespace App\Http\Requests\JobProposal;

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
            'worker_id' => ['required', 'exists:workers,id'],
            'job_post_id' => ['required', 'exists:job_posts,id'],
            'offer_amount' => ['required', 'numeric'],
            'details' => ['nullable', 'max:250'],
            'address' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'status' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'worker_id.required' => 'The worker field is required.',
            'job_post_id.required' => 'The job post field is required.',
            'latitude.required' => 'The worker latitude field is required.',
            'longitude.required' => 'The worker longitude field is required.',
            'status.required' => 'The status field is required.',
        ];
    }
}
