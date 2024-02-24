<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\ShowUserResource;
use App\Repositories\UserRepository;

/**
 * @group Authentication
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Register a new user
     *
     * This endpoint is used to register a new user.
     *
     * @unauthenticated
     *
     * @bodyParam email string required User email Example: michael@scott.com
     * @bodyParam name string required User name Example: Michael Scott
     * @bodyParam password string required User password Example: littlekidlover69
     * @bodyParam password_confirmation string required User password confirmtion Example: littlekidlover69
     *
     * @response 200 {
     * "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNzA3ODQ2NDgzLCJleHAiOjE3MDc4NTAwODMsIm5iZiI6MTcwNzg0NjQ4MywianRpIjoiWWJEMU9Ia2FtMHBVQ1JhSiIsInN1YiI6IjEwIiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyIsIm5hbWUiOiJwcmV6ZXMifQ.iSDUMleme6ztmn8cvs713_bxbNGgqzlQ-8kTWUqW83g",
     * "token_type": "bearer",
     * "expires_in": 3600
     * }
     * @response 422 {
     *     "email": [
     *         "The email has already been taken."
     *     ],
     *     "password": [
     *         "The password field must be at least 8 characters.",
     *         "The password field confirmation does not match."
     *     ]
     * }
     */
    public function register(RegisterRequest $request, UserRepository $userRepository)
    {

        $token = $userRepository->register($request);

        return $this->respondWithToken($token);
    }

    /**
     * Login
     *
     * Get a JWT via given credentials.
     *
     * @unauthenticated
     *
     * @bodyParam email string required User email Example: michael@scott.com
     * @bodyParam password string required User password Example: littlekidlover69
     *
     * @response 200 {"access_token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzA3ODQ5MjE1LCJleHAiOjE3MDc4NTI4MTUsIm5iZiI6MTcwNzg0OTIxNSwianRpIjoiNnFqVG96SU1EUUNWTEl5MyIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3IiwibmFtZSI6InByZXplcyJ9.8cIexRisn6VIky90dhJHmfZkaIntSduK30nupLa-ggI","token_type":"bearer","expires_in":3600}
     * @response 401 {"error":"Unauthorized! Those credentials didn't match our records."}
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => "Unauthorized! Those credentials didn't match our records."], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return new ShowUserResource(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string  $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
