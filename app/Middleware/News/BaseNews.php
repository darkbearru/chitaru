<?php

namespace App\Middleware\News;

abstract class BaseNews
{
    public function Format(array $items): array
    {
        return $items;
    }
}
