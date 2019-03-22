<?php

use Illuminate\Database\Seeder;
use App\Models\QuizAnswer;

class QuizAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(QuizAnswer::class,50)->create();
    }
}
