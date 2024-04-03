<?php

use App\Models\Champion;
use App\Models\User;

test('log is created when user likes a champion', function () {
    $user = User::factory()->create();

    $champion = Champion::factory()->create();

    $response = $this->actingAs($user)->post("/api/champion/like/{$champion->id}");

    $response->assertStatus(200);

    $this->assertDatabaseHas('logs', [
        'user_id' => $user->id,
        'text' => "$user->name liked $champion->name",
    ]);

    $user->delete();
    $champion->delete();
});

test('log is created when user dislikes a champion', function () {
    $user = User::factory()->create();

    $champion = Champion::factory()->create();

    $this->actingAs($user)->post("/api/champion/like/{$champion->id}");
    $response = $this->actingAs($user)->post("/api/champion/dislike/{$champion->id}");

    $response->assertStatus(200);

    $this->assertDatabaseHas('logs', [
        'user_id' => $user->id,
        'text' => "$user->name disliked $champion->name",
    ]);

    $user->delete();
    $champion->delete();
});
