<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "user_id" => $this->user_id,
            "hourly_rate" => $this->hourly_rate,
            "country_code" => $this->country_code,
            "contact_number" => $this->contact_number,
            "gender" => $this->gender,
            "personal_description" => $this->personal_description,
            "age" => $this->age,
            "birthdate" => Carbon::parse($this->birthdate)->format('Y-m-d'),
            "address" => $this->address,
            "latitude" => $this->latitude,
            "longitude" => $this->longitude,
            "is_verified_worker" => $this->is_verified_worker,
            'user' => $this->whenLoaded('user', function () {
                return new UserResource($this->user);
            }),
        ];
    }
}
