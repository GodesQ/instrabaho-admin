<?php

namespace App\Http\Requests\JobProject;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
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
            "job_id" => ['required', 'exists:project_jobs,id'],
            "job_attachments" => ['required', 'array'],
            "job_attachments.*" => ['file', 'max:2048'], // 2 MB = 2048 KB
        ];
    }

}
