<?php

use App\Models\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => "Shah Muhammad Imran",
        'email' => "admin@admin.com",
        'password' => bcrypt("123456"),
        'address' => $faker->address,
        'phone' => "+880-1866331029",
        'email_verified_at' => now(),
        'remember_token' => str_random(10)
    ];
});
