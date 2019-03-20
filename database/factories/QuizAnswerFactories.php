<?php

use Faker\Generator as Faker;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;

$factory->define(QuizAnswer::class, function (Faker $faker) {
    return [
        'question_id' => QuizQuestion::all()->random()->id,
        'answer' => $faker->word
    ];
});
