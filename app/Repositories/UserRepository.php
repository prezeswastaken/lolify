<?php

namespace App\Repositories;

use App\Http\Requests\RegisterRequest;
use App\Models\User;

class UserRepository
{
    /**
     * Registers new user, and returns its token
     *
     * @return string
     */
    public function register(RegisterRequest $request)
    {

        User::create($request->only(['email', 'name', 'password']));
        $credentials = ['email' => $request->email, 'password' => $request->password];

        if (! $token = auth()->attempt($credentials)) {

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $token;
    }
}
