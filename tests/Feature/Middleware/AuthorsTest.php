<?php

namespace Tests\Feature\Middleware;

use App\Middleware\News\Authors;
use Tests\TestCase;

class AuthorsTest extends TestCase
{

    public function testCheckFullStringQuotes()
    {
        $this->assertEquals(
            [
                [
                    'name' => '«Группа учёных, архитекторов, краеведов»',
                    'url' => '',
                    'description' => ''
                ]
            ],
            Authors::Parse('«Группа учёных, архитекторов, краеведов»'),
            'Вся строка в кавычках, не должна разбиваться не смотря на запятые внутри'
        );
    }

    public function testAuthorWithLink()
    {
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => 'http://darkbear.ru',
                'description' => ''
            ]],
            Authors::Parse('Алексей Абраменко - http://darkbear.ru'),
            'Должна определяться ссылка после дефиса'
        );
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => 'https://darkbear.ru',
                'description' => ''
            ]],
            Authors::Parse('Алексей Абраменко – https://darkbear.ru'),
            'Должна определяться ссылка после дефиса'
        );
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => 'https://darkbear.ru',
                'description' => ''
            ]],
            Authors::Parse('Алексей Абраменко — https://darkbear.ru'),
            'Должна определяться ссылка после дефиса'
        );
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => 'https://darkbear.ru',
                'description' => ''
            ]],
            Authors::Parse('Алексей Абраменко, https://darkbear.ru'),
            'Должна определяться ссылка после запятой'
        );
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => 'https://darkbear.ru',
                'description' => ''
            ]],
            Authors::Parse('Алексей Абраменко. https://darkbear.ru'),
            'Должна определяться ссылка после точки'
        );
    }

    public function testSplitAuthors()
    {
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => '',
                'description' => ''
            ], [
                'name' => 'Андрей Козлов',
                'url' => '',
                'description' => ''

            ]],
            Authors::Parse('Алексей Абраменко, Козлов Андрей'),
            'Строка должна разбиться на двух авторов в формате Имя Фамилия'
        );
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => '',
                'description' => ''
            ], [
                'name' => 'Андрей Козлов',
                'url' => 'http://chita.ru',
                'description' => ''

            ]],
            Authors::Parse('Алексей Абраменко, <a href="http://chita.ru">Козлов Андрей</a>'),
            'Строка должна разбиться на двух авторов в формате Имя Фамилия'
        );
    }

    public function testAuthorsWithInfo()
    {
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => '',
                'description' => ''
            ], [
                'name' => 'Информация рекламодателя',
                'url' => '',
                'description' => ''
            ]],
            Authors::Parse('Алексей Абраменко по информации предоставленной рекламодателем'),
            'Строка должна разбиться на двух авторов в формате Имя Фамилия'
        );
    }


    public function testDeleteExtraWords()
    {
        $this->assertEquals(
            [[
                'name' => 'Алексей Абраменко',
                'url' => '',
                'description' => ''
            ], [
                'name' => 'Татьяна Семёнова',
                'url' => '',
                'description' => ''
            ]],
            Authors::Parse('Алексей Абраменко, фото: Семёнова Татьяна'),
            'Строка должна разбиться на двух авторов в формате Имя Фамилия'
        );
    }

}
