<?php

use App\Models\User;

test('user can login', function () {
    $loginData = ['email' => 'normal_tester@test.com', 'password' => 'password'];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    $this->assertAuthenticated();
});

test("user can't login with wrong credentials", function () {
    $loginData = ['email' => 'normal_tester@test.com', 'password' => 'aaaaaaaaaaaaa'];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(401)
        ->assertJson(['error' => "Unauthorized! Those credentials didn't match our records."]);
});

test("user can't login with empty request", function () {
    $loginData = [];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(401)
        ->assertJson(['error' => "Unauthorized! Those credentials didn't match our records."]);
});

test("user can't login with only email", function () {
    $loginData = ['email' => 'normal_tester@test.com', 'password' => ''];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(401)
        ->assertJson(['error' => "Unauthorized! Those credentials didn't match our records."]);
});

test("user can't login with only password", function () {
    $loginData = ['email' => '', 'password' => ''];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(401)
        ->assertJson(['error' => "Unauthorized! Those credentials didn't match our records."]);
});

test("user can't login with imaginary credentials", function () {
    $loginData = [
        'email' => 'aaaaaaaaaaaaaaaaa',
        'password' => 'bbbbbbbbbbbbb',
    ];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(401)
        ->assertJson(['error' => "Unauthorized! Those credentials didn't match our records."]);
});

test('user can register', function () {
    $registerData = [
        'email' => 'i_am_totally_legit_user@legit.cool',
        'name' => 'totally_legit_user',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];
    $response = $this->postJson('/api/register', $registerData);
    $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    User::where('email', 'i_am_totally_legit_user@legit.cool')->delete();
});

test("user can't register without password confirmation", function () {
    $registerData = [
        'email' => 'i_am_totally_legit_user@legit.cool',
        'name' => 'totally_legit_user',
        'password' => 'password',
    ];
    $response = $this->postJson('/api/register', $registerData);
    $response
        ->assertStatus(422)
        ->assertJsonStructure(['password', 'password_confirmation']);
});

test("user can't register with different password confirmation", function () {
    $registerData = [
        'email' => 'i_am_totally_legit_user@legit.cool',
        'name' => 'totally_legit_user',
        'password' => 'password',
        'password_confirmation' => 'password1',
    ];
    $response = $this->postJson('/api/register', $registerData);
    $response
        ->assertStatus(422)
        ->assertJsonStructure(['password']);
});

test("user can't register with empty request", function () {
    $registerData = [];
    $response = $this->postJson('/api/register', $registerData);
    $response
        ->assertStatus(422)
        ->assertJsonStructure(['email', 'name', 'password', 'password_confirmation']);
});

test("user can't register with only email", function () {
    $registerData = ['email' => 'i_am_totally_legit_user@legit.cool'];
    $response = $this->postJson('/api/register', $registerData);
    $response
        ->assertStatus(422)
        ->assertJsonStructure(['name', 'password', 'password_confirmation']);
});

test('user can show their profile', function () {
    $token = JWTAuth::fromUser(User::where('email', 'normal_tester@test.com')->first());
    // Send request with bearer token in the header
    $response = $this->withHeader('Authorization', 'Bearer '.$token)->get('/api/me');
    $response
        ->assertStatus(200)
        ->assertJsonStructure([
            'name', 'email',  'is_admin', 'likes', 'logs',
        ]);
});

test("user can't show their profile without token", function () {
    $response = $this->get('/api/me');
    $response
        ->assertStatus(401)
        ->assertJson(['error' => 'Unauthenticated']);
});

test("user can't show their profile with wrong token", function () {
    $response = $this->withHeader('Authorization', 'Bearer '.'totally_fake_token')->get('/api/me');
    $response
        ->assertStatus(401)
        ->assertJson(['error' => 'Unauthenticated']);
});

test('user can logout', function () {
    $token = JWTAuth::fromUser(User::where('email', 'normal_tester@test.com')->first());
    $response = $this->withHeader('Authorization', 'Bearer '.$token)->post('/api/logout');
    $response
        ->assertStatus(200)
        ->assertJson(['message' => 'Successfully logged out']);
});

test("user can't logout without token", function () {
    $response = $this->post('/api/logout');
    $response
        ->assertStatus(401)
        ->assertJson(['error' => 'Unauthenticated']);
});

test("user can't logout with wrong token", function () {
    $response = $this->withHeader('Authorization', 'Bearer '.'totally_fake_token')->post('/api/logout');
    $response
        ->assertStatus(401)
        ->assertJson(['error' => 'Unauthenticated']);
});

test('user can login after logout', function () {
    $loginData = ['email' => 'normal_tester@test.com', 'password' => 'password'];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
});

test('user can refresh token', function () {
    $token = JWTAuth::fromUser(User::where('email', 'normal_tester@test.com')->first());
    $response = $this->withHeader('Authorization', 'Bearer '.$token)->post('/api/refresh');
    $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
});

test("user can't refresh token without token", function () {
    $response = $this->post('/api/refresh');
    $response
        ->assertStatus(401)
        ->assertJson(['error' => 'Unauthenticated']);
});

test("user can't refresh token with wrong token", function () {
    $response = $this->withHeader('Authorization ', 'Bearer '.'totally_fake_token')->post('/api/refresh');
    $response
        ->assertStatus(401)
        ->assertJson(['error' => 'Unauthenticated']);
});

test('user can login after refresh', function () {
    $loginData = ['email' => 'normal_tester@test.com', 'password' => 'password'];
    $response = $this->postJson('/api/login', $loginData);
    $response
        ->assertStatus(200)
        ->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
});
