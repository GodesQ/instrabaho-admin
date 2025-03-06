<?php

namespace App\Http\Requests\JobContract;

use App\Enum\RoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Closure;
use Illuminate\Validation\Rule;

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
            "is_client_approved" => Rule::requiredIf(!request()->user()->hasRole([RoleEnum::WORKER, RoleEnum::CLIENT])),
            "is_worker_approved" => Rule::requiredIf(!request()->user()->hasRole([RoleEnum::WORKER, RoleEnum::CLIENT])),
            "approved_terms_conditions" => ["required"]
        ];
    }
}
