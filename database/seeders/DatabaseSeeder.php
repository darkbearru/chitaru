<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\NewsType;
use App\Models\Region;
use Illuminate\Database\Seeder;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        NewsType::factory(5)->create();
        Region::factory(40)->create();
        Category::factory(30)->create();
    }
}
