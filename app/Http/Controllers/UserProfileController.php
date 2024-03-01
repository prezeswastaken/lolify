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

        if ($user == null) {
            return response()->json(['message' => 'This user does not exist!'], 404);
        }

        return new UserProfileResource($user);
    }
}
