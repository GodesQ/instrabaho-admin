<?php

namespace App\Http\Requests\WorkerReview;

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
            'reviewer_id' => ['required', 'exists:clients,id'],
            'worker_id' => ['required', 'exists:workers,id'],
            'feedback_message' => ['required', 'string', 'max:250'],
            'rate' => ['required', 'integer', 'min:1', 'max:5'],
            'questions' => 'nullable|array',
        ];
    }
}
