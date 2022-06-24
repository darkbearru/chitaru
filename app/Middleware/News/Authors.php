<?php

namespace App\Middleware\News;


final class Authors
{
    static array $_authors;

    public static function Parse(string $author): array
    {
        self::$_authors = [];

        $author = trim($author);

        // Для начала проверяем случай, урл на сайт автора идёт в скобках или после запятой, или дефиса
        if (preg_match("/(([,.\-—–\s(]*?)((http(s)?:\/\/(([-\w_]{2,}\.)+\w{2,3})(\/[-\w._]+)*)\/?(\?[-\w\d&%.+=_\-#$@]*)?)(\))?)$/u", $author, $match)) {
            $author = str_replace($match[1], '', $author);
            $url = $match[3];
            self::byAuthor($author, $url);
        } else {
            self::byAuthor($author);
        }
        return self::$_authors;
    }

    private static function byAuthor(string $author, string $url = ''): void
    {
        // Убираем лишнее
        $author = self::prepareAuthor($author);
        if (empty($author)) return;

        // сначала заменяем все запятые в кавычках, чтобы разбиение не ломало
        $author = preg_replace_callback(
            '/(["«\'].*?["»\'])/uim',
            fn($matches) => preg_replace('/,/ui', '{_}', $matches[1]),
            $author);

        $authors = explode(',', $author);

        foreach ($authors as $name) {
            $name = trim($name);
            $name = trim(self::prepareAuthor($name));
            if (empty($name)) continue;

            $words = explode(' ', $name);

            // Проверяем случай когда автор обёрнут в теге ссылки
            if (preg_match(
                '/<a\s+href\s*=\s*["\'](.*?)["\'](\s+\w+\s*=\s*["\']?(.*?)["\']?)*>(.*?)<\/a>/uim',
                $name,
                $match
            )) {
                self::byAuthor($match[4] ?? '', $match[1] ?? '');
                //self::makeAuthorObject($match[4] ?? '', '', '', $match[1] ?? '');
                continue;
            }

            // Проверяем текст в кавычках, его берём полностью
            if (preg_match('/^(«|"|\').*?(»|"|\')(.*?)$/um', $name, $matches) || (count($words) === 1)) {
                self::makeAuthorObject($name, '', $matches[3] ?? '', '');
                continue;
            }

            // Разбиваем текст на слова, по пробелу
            $other = implode(' ', array_splice($words, 2));

            list($first, $last) = $words;

            // Проверяем случаи когда имя первое потом фамилия, и наоборот
            if (self::isFirstName($first) && empty($other)) {
                self::makeAuthorObject($first, $last, $other, $url);
            } elseif (self::isFirstName($last) && empty($other)) {
                self::makeAuthorObject($last, $first, $other, $url);
            } else {
                // Тут уже что-то третье пихаем как есть
                self::makeAuthorObject($name, '', '', $url);
            }
        }
    }

    /**
     * prepareAuthor
     * Убираем лишние символы, корректируем часть предложений, всё лишнее прочь
     *
     * @param string $author
     * @return string
     */
    private static function prepareAuthor(string $author): string
    {
        $author = preg_replace("/,?\s+по\s+(информаци[ия]|материал(ам|ы)),?\s+предоставленной\s+рекламодателем$/ui", ", Информация рекламодателя", $author);
        $author = preg_replace("/\s+по (материалам|информации)\s+/ui", ", ", trim($author));
        return preg_replace("/(^\.+$|^\*$|^\*\*\*$|^[Вв]ыборы$|^\w$|^[Фф]ото\s?[-:—–]?|^&nbsp;$|для\s+Чита.Ру$)/ui", "", $author);
    }

    private static function makeAuthorObject(string $first, string $last = '', string $description = '', string $url = ''): void
    {
        $name = preg_replace('/\{_}/ui', ',', self::changeEnglishLetters(trim($first . ' ' . $last)));
        $_result = [
            'name' => $name,
            'url' => $url,
            'description' => $description
        ];
        self::$_authors[] = $_result;
    }

    /**
     * @param string $author
     * @return string
     */
    public static function changeEnglishLetters(string $author): string
    {
        if (!preg_match_all('/([a-z])/ui', $author, $matches, PREG_SET_ORDER)) return $author;

        $percent = (count($matches) / mb_strlen($author, 'utf-8')) * 100;

        if ($percent > 15) return $author;

        $find = ['/C/i', '/E/i', '/A/i', '/T/i', '/O/i', '/B/i', '/K/i', '/X/i'];
        $replace = ['С', 'Е', 'А', 'Т', 'О', 'В', 'К', 'Х'];
        return preg_replace($find, $replace, $author);
    }

    private static function isFirstName(string $name): bool
    {
        return preg_match(
            '/((серг|алекс|андр)ей|петр|иван|александр|игорь|оля|(ольг|татьян|томар|свет|екатерин|марин)([аыу])|(юли|юл|наст|олес|кат)[яюеи])$/uism',
            mb_strtolower($name, 'utf-8')
        );
    }
}
