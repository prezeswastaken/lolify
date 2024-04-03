<?php

use App\Models\Champion;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('normal user cant access champion create route', function () {
    $response = $this->actingAs(User::factory()->make())->post('/api/champion');
    $response->assertStatus(403);
});

test('unauthenticated user cant access champion create route', function () {
    $response = $this->post('/api/champion');
    $response->assertStatus(401);
});

test("admin can't create champion with empty request", function () {
    $response = $this->actingAs(User::factory()->admin()->make())->post('/api/champion');
    $response->assertStatus(422);
});

test('admin can create champion and store their images for champion, skills and skins with valid request', function () {
    Storage::fake('local');
    $image = UploadedFile::fake()->image('aatrox.jpg');

    $response = $this->actingAs(User::factory()->admin()->make())->post('/api/champion', [
        'name' => 'Aatrox',
        'title' => 'The Darkin Blade',
        'description' => 'Aatrox is a legendary warrior, one of only five that remain of an ancient',
        'image_file' => $image,
        'roles' => ['1', '2'],
        'q_name' => 'The Darkin Blade',
        'q_image_file' => $image,
        'w_name' => 'Infernal Chains',
        'w_image_file' => $image,
        'e_name' => 'Umbral Dash',
        'e_image_file' => $image,
        'r_name' => 'World Ender',
        'r_image_file' => $image,
        'passive_name' => 'Deathbringer Stance',
        'passive_image_file' => $image,
        'skin_1_image_file' => $image,
        'skin_2_image_file' => $image,
        'skin_3_image_file' => $image,
        'skin_4_image_file' => $image, ]);

    $response->assertStatus(201);
    $response->assertJsonStructure([
        'id',
        'name',
        'title',
        'description',
        'image_link',
        'created_at',
        'updated_at',
    ]);

    $champion = Champion::find($response['id']);

    $assetPaths = [
        $champion->image_link,
        ...array_column($champion->skills->toArray(), 'image_link'),
        ...array_column($champion->skins->toArray(), 'image_link'),
    ];

    foreach ($assetPaths as $assetPath) {
        $image_path = explode('/storage', $assetPath)[1];
        $image_path = 'public'.$image_path;
        Storage::assertExists($image_path);
    }

});

test('admin can delete champions', function () {
    $champion = Champion::factory()->create();
    $this->assertNotNull(Champion::find($champion->id));

    $response = $this->actingAs(User::factory()->admin()->make())->delete("/api/champion/$champion->id");
    $response->assertStatus(200);
    $this->assertNull(Champion::find($champion->id));

});

test("normal user can't delete champions", function () {
    $champion = Champion::factory()->create();
    $this->assertNotNull(Champion::find($champion->id));

    $response = $this->actingAs(User::factory()->make())->delete("/api/champion/$champion->id");
    $response->assertStatus(403);
    $this->assertNotNull(Champion::find($champion->id));

});
