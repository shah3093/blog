<?php

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'featuredImage' => $faker->imageUrl($width = 640, $height = 480)
    ];
});
