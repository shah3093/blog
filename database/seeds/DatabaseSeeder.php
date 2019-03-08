<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(PageSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SeriesSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(VisitorSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(QuestionTypeSeeder::class);
    }
}
