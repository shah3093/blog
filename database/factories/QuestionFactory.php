<?php

use App\Models\Question;
use App\Models\Visitor;
use Faker\Generator as Faker;

$factory->define(Question::class, function(Faker $faker) {
    return [
        'title'      => $faker->sentence($nbWords = 7, $variableNbWords = true),
        'details'    => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'visitor_id' => Visitor::all()->random()->id,
        'show'       => 1,
        'status'     => 'PENDING'
    ];
});
