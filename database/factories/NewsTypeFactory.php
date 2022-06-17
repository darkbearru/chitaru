<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NewsType>
 */
class NewsTypeFactory extends Factory
{
    /**
     * Дефолтный справочник, с оригинальными ID для более простого импорта текстов
     * @var array|string[][]
     */
    protected array $default = [
        [
            'id' => '1',
            'name' => 'Новости',
            'token' => 'news'
        ],
        [
            'id' => '2',
            'name' => 'Статьи',
            'token' => 'articles'
        ],
        [
            'id' => '4',
            'name' => 'Фоторепортажи',
            'token' => 'photos'
        ],
        [
            'id' => '5',
            'name' => 'Обзоры',
            'token' => 'reviews'
        ],
        [
            'id' => '9',
            'name' => 'Блоги',
            'token' => 'blogs'
        ]
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $result = array_shift($this->default);
        if (!empty($result)) return $result;

        return [
            'name' => $this->faker->word(),
            'token' => $this->faker->unique()->word()
        ];
    }
}
