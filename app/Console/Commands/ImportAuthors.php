<?php

namespace App\Console\Commands;

use App\Middleware\News\Authors;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportAuthors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:authors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importing authors from Chita.Ru';

    private array $_authors = [];

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->newLine(5);

        $oldDB = DB::connection("mysql_old");
        $oldCount = (int)$oldDB->select("select sum(cnt) as cnt from (SELECT count(id) as cnt FROM old_chita_ru.news
            WHERE flags&1 and TRIM(author) > '' and upid in (1,2,3,4,5) group by author) as t")[0]->cnt;
        $oldCount += (int)$oldDB->select("SELECT count(id) as cnt FROM old_chita_ru.news WHERE upid=9 and flags&1")[0]->cnt;


        $current = 0;
        $step = 300;

        $this->clearAuthorsTable();

        $bar = $this->output->createProgressBar($oldCount);
        $bar->start();
        while ($current < $oldCount) {
            $recs = $oldDB->select(
                "SELECT distinct author FROM news
                WHERE flags&1 and TRIM(author) > '' and upid in (1,2,3,4,5)
                LIMIT $current, $step"
            );

            $this->import($recs);

            $current += $step;
            $bar->advance($step);
        }
        $recs = $oldDB->select("SELECT distinct name as author FROM news WHERE flags&1 and upid=9");
        $this->import($recs);

        $bar->finish();
        return 0;
    }

    private function clearAuthorsTable(): void
    {
        DB::delete("delete from authors");
    }

    private function import(array $recs): void
    {
        $authors = $this->getAuthors($recs);


        DB::connection('pgsql');
        try {
            DB::beginTransaction();
            foreach ($authors as $author) {
                if ((int)DB::select("select count(id) as cnt from chitaru.authors where name=:name", [$author['name']])[0]->cnt === 0) {
                    DB::insert(
                        "INSERT INTO chitaru.authors (name, url, description, created_at, updated_at) values(:name, :url, :description, now(), now())",
                        $author
                    );
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            $this->newLine();
            $this->error("Ошибка", $e);
            DB::rollBack();
        }

    }

    private function getAuthors(array $recs): array
    {
        $_authors = [];
        foreach ($recs as $rec) {
            $_authors = array_merge($_authors, Authors::Parse($rec->author));
        }
        return $_authors;
    }
}
