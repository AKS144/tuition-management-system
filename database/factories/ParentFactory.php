<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Parents;
use Faker\Generator as Faker;

$factory->define(Parents::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'nric' => $faker->e164PhoneNumber(),
        'mobile_no' => $faker->e164PhoneNumber(),
        'email' => $faker->unique()->safeEmail
    ];
});
