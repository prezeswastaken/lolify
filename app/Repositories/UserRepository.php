<?php

namespace App\Repositories;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

class UserRepository
{
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->only(['email', 'name', 'password']));

        return $user;
    }
}
