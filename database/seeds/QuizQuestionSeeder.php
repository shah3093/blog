<?php

use Illuminate\Database\Seeder;
use App\Models\QuizQuestion;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(QuizQuestion::class,10)->create();
    }
}
