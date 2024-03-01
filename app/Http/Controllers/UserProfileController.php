<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserProfileResource;
use App\Models\User;

class UserProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function profile(string $username)
    {

        $user = User::whereName($username)->first();

        return new UserProfileResource($user);
    }
}
