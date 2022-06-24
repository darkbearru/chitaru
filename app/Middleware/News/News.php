<?php

namespace App\Middleware\News;

class News extends BaseNews
{
    use PostProcess, StandartView;

    public function Format(array $items): array
    {
        foreach ($items as $key => $item) {
            $item = self::postProcess($item);
            $items[$key] = self::prepareView($item);
        }
        return $items;
    }
}
