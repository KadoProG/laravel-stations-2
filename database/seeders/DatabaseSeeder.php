<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Practice;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Practice::factory(10)->create();
        // 外部キーになるDBを先に作っておきます
        Genre::factory(10)->create();
        Movie::factory(40)->create();
    }
}
