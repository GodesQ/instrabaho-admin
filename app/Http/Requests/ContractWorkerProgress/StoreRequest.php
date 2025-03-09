<?php

namespace App\Http\Requests\ContractWorkerProgress;

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
            "contract_id" => ["required", "exists:job_contracts,id"],
            "worker_id" => ["required", "exists:workers,id"],
            "status" => ["required", "in:preparing,on_way,arriving,arrived,working,done,cancelled"],
            "comment" => ["nullable"],
            "arrived_at" => ["required_if:status,arrived"],
            "started_working_at" => ["required_if:status,working"],
            "finished_working_at" => ["required_if:status,done"],
        ];
    }
}
