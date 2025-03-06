<?php

namespace App\Http\Requests\JobContract;

use App\Rules\RequiredApproval;
use Illuminate\Foundation\Http\FormRequest;
use Closure;

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
        $user = auth()->user();
        return [
            "proposal_id" => ["required"],
            "client_id" => ["required"],
            "contract_amount" => ["required", "numeric"],
            "is_client_approved" => [
                function (string $attribute, mixed $value, Closure $fail) use ($user) {
                    if ($user->hasRole(['worker', 'client']) && is_null($value)) {
                        $fail("The {$attribute} field is required.");
                    }
                },
            ],
            "is_worker_approved" => [
                function (string $attribute, mixed $value, Closure $fail) use ($user) {
                    if ($user->hasRole(['worker', 'client']) && is_null($value)) {
                        $fail("The {$attribute} field is required.");
                    }
                },
            ],
        ];
    }
}
