<?php

namespace Database\Factories;

use App\Models\Champion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Champion>
 */
class ChampionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => 'A mage who wields the power of true ice, using it to bring an end to all who oppose her.',
            'title' => 'The Ice Witch',
            'image_link' => 'fake_image_link.jpg',
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (Champion $champion) {
            // ...
        })->afterCreating(function (Champion $champion) {
            $champion->skills()->createMany([
                ['name' => 'q_skill', 'image_link' => 'fake_image_link.jpg', 'letter' => 'q'],
                ['name' => 'w_skill', 'image_link' => 'fake_image_link.jpg', 'letter' => 'w'],
                ['name' => 'e_skill', 'image_link' => 'fake_image_link.jpg', 'letter' => 'e'],
                ['name' => 'r_skill', 'image_link' => 'fake_image_link.jpg', 'letter' => 'r'],
                ['name' => 'passive_skill', 'image_link' => 'fake_image_link.jpg', 'letter' => 'passive'],
            ]);

            $champion->roles()->attach([3]);

            $champion->skins()->createMany([
                ['image_link' => 'fake_image_link.jpg'],
                ['image_link' => 'fake_image_link.jpg'],
            ]);
        });

    }
}
