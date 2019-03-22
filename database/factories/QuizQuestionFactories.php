<?php

use Faker\Generator as Faker;
use App\Models\Post;
use App\Models\QuizQuestion;
use App\Models\Quiz;

$factory->define(QuizQuestion::class, function (Faker $faker) {
    return [
       'quiz_id' => Quiz::all()->random()->id,
       'question' => $faker->sentence($nbWords = 10, $variableNbWords = true)
    ];
});
