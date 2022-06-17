<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Дефолтный справочник, с оригинальными ID для более простого импорта текстов
     * @var array|string[][]
     */
    protected array $default = [
        [
            'id' => '1',
            'name' => 'Политика и власть',
            'token' => 'politics'
        ],
        [
            'id' => '2',
            'name' => 'Мой город',
            'token' => 'my_city'
        ],
        [

            'id' => '3',
            'name' => 'Связь и телекоммуникации',
            'token' => 'telecommunications'
        ],
        [
            'id' => '4',
            'name' => 'Международные отношения',
            'token' => 'international'
        ],
        [
            'id' => '5',
            'name' => 'Наука и образование',
            'token' => 'science'
        ],
        [

            'id' => '6',
            'name' => 'Культура и искусство',
            'token' => 'culture'
        ], [

            'id' => '7',
            'name' => 'Спорт',
            'token' => 'sport'
        ], [

            'id' => '8',
            'name' => 'Конкурсы и выставки',
            'token' => 'exhibitions'
        ], [

            'id' => '9',
            'name' => 'Экология',
            'token' => 'ecology'
        ], [
            'id' => '10',
            'name' => 'Происшествия и криминал',
            'token' => 'criminal'
        ], [
            'id' => '11',
            'name' => 'Бизнес и экономика',
            'token' => 'business'
        ], [
            'id' => '12',
            'name' => 'Человек и общество',
            'token' => 'society'
        ], [
            'id' => '14',
            'name' => 'Новости компаний',
            'token' => 'companies'
        ], [
            'id' => '17',
            'name' => 'Армия',
            'token' => 'army'
        ], [
            'id' => '18',
            'name' => 'Здоровье',
            'token' => 'health'
        ],
        [
            'id' => '19',
            'name' => 'Религия',
            'token' => 'religion'
        ],
        [
            'id' => '20',
            'name' => 'Сельское хозяйство',
            'token' => 'agriculture'
        ],
        [
            'id' => '21',
            'name' => 'Опросы',
            'token' => 'quiz'
        ],
        [
            'id' => '23',
            'name' => 'Интервью',
            'token' => 'interview'
        ],
        [
            'id' => '24',
            'name' => 'Комментарии',
            'token' => 'comments'
        ],
        [
            'id' => '29',
            'name' => 'Обзоры дня',
            'token' => 'day'
        ],
        [
            'id' => '30',
            'name' => 'Обзоры недели',
            'token' => 'week'
        ],
        [
            'id' => '31',
            'name' => 'Обзоры месяца',
            'token' => 'month'
        ],
        [
            'id' => '32',
            'name' => 'Обзоры года',
            'token' => 'year'
        ],
        [
            'id' => '33',
            'name' => 'Обзоры районных СМИ',
            'token' => 'district'
        ],
        [
            'id' => '34',
            'name' => 'Обзоры краевых СМИ',
            'token' => 'region'
        ],
        [
            'id' => '35',
            'name' => 'Обзоры электронных СМИ',
            'token' => 'online'
        ],
        [
            'id' => '36',
            'name' => 'Обзоры цитат',
            'token' => 'quotes'
        ],
        [
            'id' => '37',
            'name' => 'Обзоры китайских СМИ',
            'token' => 'china_media'
        ],
        [
            'id' => '38',
            'name' => 'Обзоры зарубежных СМИ',
            'token' => 'foreign_media'
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
