<?php

namespace App\Http\Controllers;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class NewsController extends Controller
{
    private const ITEMS_CACHE_MINUTES = 30;
    private const ITEM_CACHE_MINUTES = 180;

    public function Items(): object
    {
        $currentPage = Paginator::resolveCurrentPage('page');
        $pages = cache()->remember(
            "news.page.{$currentPage}",
            now()->addMinutes(self::ITEMS_CACHE_MINUTES),
            function () {
                return News::Recs();
            }
        );

        return (object)[
            'items' => $this->Format($pages->items()),
            'currentPage' => $pages->currentPage(),
            'lastPage' => $pages->lastPage()
        ];
    }

    protected function Format(array $items): array
    {
        foreach ($items as $idx => $item) {
            $items[$idx] = $this->DateFormat($item);
        }
        return $items;
    }

    protected function DateFormat(object $item): object
    {
        $item->published_at =
            Carbon::createFromFormat('Y-m-d H:i:s', $item->published_at)
                ->locale('ru')
                ->isoFormat('Do MMMM, HH:mm');
        return $item;
    }

}
