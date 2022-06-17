<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_id' => 1,
            'region_id' => 5,
            'category_id' => 2,
            'author_id' => 1,
            'photo_id' => 1,
            'opinions_id' => 1,
            'title' => $this->faker->sentence(4),
            'anons' => $this->faker->sentence(10),
            'text' => $this->faker->paragraph(),
            'flags' => 1,
            'tags' => '[]',
            'extensions' => '[]',
            'published_at' => now()
        ];
    }
}
