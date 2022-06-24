<?php

namespace App\Console\Commands;

use App\Middleware\News\Authors;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing old news to new format';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->newLine(1);
        $this->line('==============================================================');
        $this->line('           Импортирование старой базы Chita.Ru');
        $this->line('==============================================================');
        if (!$this->confirm('Процедура может занять много времени, продолжить?', true)) return 0;


        $oldDB = DB::connection("mysql_old");

        $oldCount = (int)$oldDB->select('SELECT count(id) as cnt FROM news WHERE flags&1 and upid > 0')[0]->cnt;

        $current = 0;
        $step = 200;
        $bar = $this->output->createProgressBar($oldCount);
        $bar->start();

        while ($current < $oldCount) {
            $recs = $oldDB->select(
                "SELECT
                    id, upid, if (upid not in (1, 2,4,5), 9, upid) as upid2,
                    cnt_opinions, name, anons, txt, ext, tags,
                    news_type, category, news_date, news_time,
                    author, opinions, photo_id, flags, created, changed
                    FROM news WHERE flags&1 and
                    upid in (SELECT 2 UNION SELECT 4 UNION SELECT 5 UNION SELECT 1 UNION SELECT id FROM news WHERE upid=9)
                    ORDER BY id LIMIT $current, $step"
            );
            $this->import($recs);
            $current += $step;
            $bar->advance($step);
        }

        $bar->finish();

        $this->newLine(1);
        $this->line('==============================================================');
        $this->line('                       Импорт завершён');
        $this->line('==============================================================');
        $this->newLine(1);
        return 0;
    }

    private function import(array $recs): void
    {
        DB::connection('pgsql');
        DB::beginTransaction();
        try {
            foreach ($recs as $rec) {
                DB::insert('insert into news
                     (type_id, region_id, category_id, photo_id, opinions_id,
                      title, anons, text, flags, author, tags, extensions, published_at, created_at, updated_at)
                      values (
                        :type_id, :region_id, :category_id,
                        :photo_id, :opinions_id, :title, :anons,
                        :text, :flags, :author, :tags, :extensions, :published_at, now(), now()
                        )',
                    $this->prepareFields($rec)
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            $this->newLine();
            $this->error("Ошибка", $e);
            DB::rollBack();
        }
    }

    private function prepareFields(object $rec): array
    {
        $fields = [];
        $fields['type_id'] = $rec->upid2;
        $fields['region_id'] = $rec->news_type ?? 4;
        $fields['category_id'] = $rec->category;
        $fields['opinions_id'] = $rec->opinions;
        $fields['photo_id'] = $rec->photo_id;
        $fields['title'] = $rec->name;
        $fields['anons'] = $rec->anons;
        $fields['text'] = $rec->txt;
        $fields['flags'] = $rec->flags;
        $fields['author'] = $this->getAuthors($rec);
        $fields['tags'] = $this->getTags($rec->tags);
        $fields['extensions'] = $this->getExt($rec->ext);
        $fields['published_at'] = $this->getPublishDate($rec);

        return $fields;
    }

    private function getAuthors(object $rec): string
    {
        if (empty(trim($rec->author))) return "[]";
        $authors = Authors::Parse($rec->author);
        if (empty ($authors)) return "[]";

        $list = [];
        foreach ($authors as $author) {
            $list[] = "'" . $author['name'] . "'";
        }

        DB::connection('pgsql');
        $res = DB::select('select id, name from chitaru.authors where name in (' . implode(',', $list) . ')');
        return json_encode($res, JSON_UNESCAPED_UNICODE);
    }

    private function getTags($tags): string
    {
        if (empty($tags)) return "[]";
        try {
            json_decode($tags);
        } catch (\Exception $e) {
            $tags = "[]";
        }
        return $tags;
    }

    private function getExt($ext): string
    {
        $_ext = [];
        if (!empty($ext)) {
            $ext = @unserialize($ext);
            if (is_array($ext)) {
                foreach ($ext as $item) {
                    $_ext[mb_strtolower($item[0], 'utf-8')] = (object)['value' => trim($item[1]), 'description' => $item[2]];
                }
            }
        }
        return json_encode($_ext, JSON_UNESCAPED_UNICODE);
    }

    private function getPublishDate(object $rec): string
    {
        $date = $rec->news_date . ' ' . $rec->news_time;
        if (!preg_match('/^20[012]\d-(0\d|1[012])-\d{2}/us', $date)) {
            $date = $rec->created ?? $rec->changed ?? strtotime('-7 year');
        }
        return $date;
    }
}
