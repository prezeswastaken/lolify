<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'is_admin' => $this->is_admin,
            'email' => $this->email,
            'likes' => $this->likes,
            'logs' => new LogResourceCollection($this->logs),
        ];
    }
}
