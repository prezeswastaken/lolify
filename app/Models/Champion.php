<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JWTAuth;

class Champion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function skins()
    {
        return $this->hasMany(ChampionImage::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function currentUserLikesIt()
    {
        $user = JWTAuth::user();

        if (! $user) {
            return false;
        }

        if ($user->likes) {
            return $user->likes->contains($this);
        } else {
            return false;
        }
    }
}
