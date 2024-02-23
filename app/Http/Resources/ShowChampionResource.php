<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowChampionResource extends JsonResource
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
            'name' => $this->name,
            'image_link' => $this->image_link,
            'description' => $this->description,
            'title' => $this->title,
            'current_user_likes_it' => $this->currentUserLikesIt(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'likes_count' => $this->users->count(),
            'users_that_liked' => $this->users,
            'roles' => $this->roles,
            'skills' => $this->skills,
            'skins' => $this->skins,
        ];
    }
}
