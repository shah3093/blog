<?php

use Faker\Generator as Faker;
use App\Models\Post;
use App\Models\Quiz;

$factory->define(Quiz::class, function (Faker $faker) {
    return [
        'name'             => $faker->company,
        'post_id'        =>  Post::all()->random()->id,
        'description'      => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        'featuredImage'    => $faker->imageUrl($width = 640, $height = 480),
        'seo_descriptions' => $faker->realText($maxNbChars = 250, $indexSize = 2),
        'seo_keywords'     => "testing,testing one,tsting two"
    ];
});
