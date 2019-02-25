<?php

use App\Models\Series;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {
    return [
        'name'             => $faker->company,
        'description'      => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'featuredImage'    => $faker->imageUrl($width = 640, $height = 480),
        'seo_descriptions' => $faker->realText($maxNbChars = 250, $indexSize = 2),
        'seo_keywords'     => "testing,testing one,tsting two"
    ];
});
