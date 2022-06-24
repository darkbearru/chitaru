<?php

namespace App\Middleware\News;


use Carbon\Carbon;

/**
 * Постобработка данных новостей для вывода
 * --------------------------
 * На старте только обработка даты, остальное по мере работ
 */
trait PostProcess
{
    /**
     * Основной метод постобработки, принимает либо массив, либо единичный элемент
     * @param object|array $items
     * @return object|array
     */
    public function postProcess(object|array $items): object|array
    {
        if (!is_array($items)) return $this->postProcessOne($items);
        foreach ($items as $key => $item) {
            $items[$key] = $this->postProcessOne($item);
        }
        return $items;
    }

    /**
     * @param object $item
     * @return object
     */
    private function postProcessOne(object $item): object
    {
        return $this->DateFormat($item);
    }

    /**
     * @param object $item
     * @return object
     */
    protected function DateFormat(object $item): object
    {
        $item->published_at =
            Carbon::createFromFormat('Y-m-d H:i:s', $item->published_at)
                ->locale('ru')
                ->isoFormat('Do MMMM, HH:mm');
        return $item;
    }

}
