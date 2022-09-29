<?php

namespace Database\Seeders;

use App\Models\JobVacancyResponse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobVacancyResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JobVacancyResponse::factory(500)->create();
    }
}
