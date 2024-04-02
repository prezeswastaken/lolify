<?php

test('champion index returns status 200', function () {
    $response = $this->get('/api/champion');

    $response->assertStatus(200);
});

test('champion index returns champion array', function () {
    $response = $this->get('/api/champion');

    $response->assertJsonStructure([[
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
        'image_link',
        'title',
    ]]);
});

test('champion show returns status 200', function () {
    $response = $this->get('/api/champion/6');

    $response->assertStatus(200);
});

test('champion show returns champion object', function () {
    $response = $this->get('/api/champion/6');

    $response->assertJsonStructure([
        'id',
        'name',
        'image_link',
        'description',
        'title',
        'current_user_likes_it',
        'created_at',
        'updated_at',
        'likes_count',
        'users_that_liked',
        'roles',
        'skills',
        'skins',
    ]);
});

test('top 3 returns champions json', function () {
    $response = $this->get('/api/top3/champion');

    $response->assertJsonStructure([[
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
        'image_link',
        'title',
    ]]);
});
