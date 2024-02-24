<?php

test('champion index returns champion array', function () {
    $response = $this->get('/api/champion');

    $response->assertStatus(200)->assertJsonStructure([[
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
        'image_link',
        'title',
    ]]);
});

test('champion show returns champion object', function () {
    $response = $this->get('/api/champion/1');

    $response->assertStatus(200)->assertJsonStructure([
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
        'image_link',
        'title',
        'current_user_likes_it',
        'likes_count',
        'users_that_liked',
        'roles',
        'skills',
        'skins',
    ]);
});
