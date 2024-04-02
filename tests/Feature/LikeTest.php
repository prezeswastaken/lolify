<?php

use App\Models\Champion;
use App\Models\User;

test('user can like a champion', function () {
    $user = User::factory()->create();

    assert($user->likes->isEmpty());

    $champion = Champion::factory()->create();

    $response = $this->actingAs($user)->post("/api/champion/like/{$champion->id}");

    $response->assertStatus(200);

    $this->assertTrue($user->likes->contains($champion));

    $user->delete();
});

test('user can dislike a champion', function () {
    $user = User::factory()->create();

    $champion = Champion::factory()->create();

    $user->likes()->attach($champion);

    $response = $this->actingAs($user)->post("/api/champion/dislike/{$champion->id}");

    $response->assertStatus(200);

    $this->assertFalse($user->likes->contains($champion));

    $user->delete();
});

test("user can't like a champiion that dosen't exist", function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/api/champion/like/1023');

    $response->assertStatus(404);

    $user->delete();
});
