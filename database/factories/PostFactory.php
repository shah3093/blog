<?php

use App\Models\Category;
use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'content' => $faker->realText($maxNbChars = 1000, $indexSize = 2),
        'featuredImage' => $faker->imageUrl(640,480),
        'categoryId' => Category::all()->random()->id
    ];
});
