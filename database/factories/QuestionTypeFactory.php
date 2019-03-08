<?php

use App\Models\QuestionType;
use Faker\Generator as Faker;

$factory->define(QuestionType::class, function (Faker $faker) {
    return [
        'type' => $faker->unique()->word
    ];
});
