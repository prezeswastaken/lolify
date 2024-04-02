<?php

use App\Models\User;

test("user can show other user's profile by their name", function () {
    $user = User::factory()->create();
    $user2 = User::factory()->create();

    $response = $this->actingAs($user)->get("/api/profile/{$user2->name}");

    $response->assertStatus(200);
    $response->assertJsonStructure([
        'name',
        'email',
        'is_admin',
        'email',
        'likes',
        'logs',
    ]);

    $user->delete();
    $user2->delete();
});

test("user can't show user that dosen't exist", function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/api/profile/doesntexist');

    $response->assertStatus(404);

    $user->delete();
});
