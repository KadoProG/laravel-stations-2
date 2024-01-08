<?php

namespace Database\Seeders;

use App\Practice;
use Illuminate\Database\Seeder;

class PracticeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Practice::factory(10)->create();
    }
}
