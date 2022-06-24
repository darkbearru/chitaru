<?php

namespace App\Http\Controllers;

use App\Middleware\News\News;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class NewsController extends Controller
{
    private const ITEMS_CACHE_MINUTES = 30;
    private const ITEM_CACHE_MINUTES = 180;


    public function index(): object
    {
        $currentPage = Paginator::resolveCurrentPage('page');
        $noCache = App::environment('local') ?? false;

        try {
            $recs = cache()->get("news.page.{$currentPage}");
        } catch (\Exception|NotFoundExceptionInterface $e) {
            $recs = null;
        } catch (ContainerExceptionInterface $e) {
        }

        if ($noCache || empty($recs)) {
            $recs = $this->getData(News::class);
            cache()->put(
                "news.page.{$currentPage}",
                $recs,
                now()->addMinutes(self::ITEMS_CACHE_MINUTES)
            );
        }

        return \view('main-page', [
            'news' => $recs
        ]);
    }

    protected function getData(string $class, array $filters = []): object
    {
        $pages = \App\Models\News::Recs($filters);
        $class = new $class();
        return (object)[
            'items' => $class->Format($pages->items()),
            'currentPage' => $pages->currentPage(),
            'lastPage' => $pages->lastPage()
        ];
    }

    public function showByType(string $type, int $id = 0): View
    {
        $pages = \App\Models\News::Recs(["type" => $type]);
        dd($pages);
        $viewName = '';
        $viewData = [];
        return \view($viewName, $viewData);
    }

    public function showBlogs($author, int $id): View
    {
        $viewName = '';
        $viewData = [];
        return \view($viewName, $viewData);
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
