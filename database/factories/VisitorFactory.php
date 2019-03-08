<?php

use App\Models\Visitor;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Visitor::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'email_verified_at' => Carbon::now()->toDateTimeString(),
        'password' => bcrypt('123456'),
        'status' => 1
    ];
});
