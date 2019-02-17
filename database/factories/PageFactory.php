<?php

use App\Models\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'title'            => $faker->sentence($nbWords = 10, $variableNbWords = true),
        'content'          => $faker->realText($maxNbChars = 10000, $indexSize = 2),
        'featuredImage'    => $faker->imageUrl(640, 480),
        'seo_descriptions' => $faker->realText($maxNbChars = 250, $indexSize = 2),
        'seo_keywords'     => "testing,testing one,tsting two"
    ];
});
