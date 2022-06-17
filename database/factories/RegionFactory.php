<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Region>
 */
class RegionFactory extends Factory
{
    protected array $default = [
        ['id' => '1', 'name' => 'В мире', 'token' => 'world'],
        ['id' => '2', 'name' => 'В России', 'token' => 'russia'],
        ['id' => '3', 'name' => 'Приграничье', 'token' => 'neighbours'],
        ['id' => '4', 'name' => 'Забайкальский край', 'token' => 'kray'],
        ['id' => '5', 'name' => 'Чита', 'token' => 'chita'],
        ['id' => '8', 'name' => 'Краснокаменск', 'token' => 'redstone'],
        ['id' => '9', 'name' => 'Агинский район', 'token' => 'aginsk'],
        ['id' => '10', 'name' => 'Акшинский район', 'token' => 'aksha'],
        ['id' => '11', 'name' => 'Александрово-Заводский район', 'token' => 'alekzavod'],
        ['id' => '12', 'name' => 'Балейский район', 'token' => 'baley'],
        ['id' => '13', 'name' => 'Борзинский район', 'token' => 'borzya'],
        ['id' => '14', 'name' => 'Газимуро-Заводский район', 'token' => 'gazzavod'],
        ['id' => '15', 'name' => 'Дульдургинский район', 'token' => 'duldurga'],
        ['id' => '16', 'name' => 'Забайкальский район', 'token' => 'zabaykalsk'],
        ['id' => '17', 'name' => 'Каларский район', 'token' => 'kalarsky'],
        ['id' => '18', 'name' => 'Калганский район', 'token' => 'kalga'],
        ['id' => '19', 'name' => 'Карымский район', 'token' => 'karymsk'],
        ['id' => '20', 'name' => 'Краснокаменский район', 'token' => 'krasno'],
        ['id' => '21', 'name' => 'Красночикойский район', 'token' => 'chikoy'],
        ['id' => '22', 'name' => 'Кыринский район', 'token' => 'kyra'],
        ['id' => '23', 'name' => 'Могойтуйский район', 'token' => 'mogoit'],
        ['id' => '24', 'name' => 'Могочинский район', 'token' => 'mogocha'],
        ['id' => '25', 'name' => 'Нерчинский район', 'token' => 'nerchinsk'],
        ['id' => '26', 'name' => 'Нерчинско-Заводский район', 'token' => 'nerzavod'],
        ['id' => '27', 'name' => 'Оловяннинский район', 'token' => 'olovyan'],
        ['id' => '28', 'name' => 'Ононский район', 'token' => 'onon'],
        ['id' => '29', 'name' => 'Петровск-Забайкальский район', 'token' => 'petrozab'],
        ['id' => '30', 'name' => 'Приаргунский район', 'token' => 'argun'],
        ['id' => '31', 'name' => 'Сретенский район', 'token' => 'sretensk'],
        ['id' => '32', 'name' => 'Тунгиро-Олёкминский район', 'token' => 'tungiro'],
        ['id' => '33', 'name' => 'Тунгокоченский район', 'token' => 'tungo'],
        ['id' => '34', 'name' => 'Улётовский район', 'token' => 'ulety'],
        ['id' => '35', 'name' => 'Хилокский район', 'token' => 'hilok'],
        ['id' => '36', 'name' => 'Чернышевский район', 'token' => 'chern'],
        ['id' => '37', 'name' => 'Читинский район', 'token' => 'chininsky'],
        ['id' => '38', 'name' => 'Шелопугинский район', 'token' => 'shelopugin'],
        ['id' => '39', 'name' => 'Шилкинский район', 'token' => 'shilka'],
        ['id' => '40', 'name' => 'Горный', 'token' => 'gorny'],
        ['id' => '41', 'name' => 'Агинский округ', 'token' => 'okrug'],
        ['id' => '42', 'name' => 'Дальний Восток', 'token' => 'dv']
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
