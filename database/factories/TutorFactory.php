<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tutor;
use Faker\Generator as Faker;

$factory->define(Tutor::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'nric' => $faker->e164PhoneNumber(),
        'age' => $faker->numberBetween(17, 45),
        'mobile_no' => $faker->e164PhoneNumber(),
        'date_employed'=> now(),
        'status' => $faker->numberBetween(0,2),
        'is_active' => $faker->numberBetween(0,1),
        'experience' => $faker->numberBetween(1,20),
        'branch_id' => $faker->numberBetween(1,2),
    ];
});
