<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'profile_photo' => $this->profile_photo,
            'email_verified_at' => $this->email_verified_at,
            'status' => $this->status,
            'worker' => $this->whenLoaded('worker', function () {
                return WorkerResource::make($this->worker);
            }),
            'client' => $this->whenLoaded('client', function () {
                return ClientResource::make($this->client);
            }),
        ];
    }
}
