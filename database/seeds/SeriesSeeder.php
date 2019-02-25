<?php

use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(Series::class, 5)->create();
    }
}
