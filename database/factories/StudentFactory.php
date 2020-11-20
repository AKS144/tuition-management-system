<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use Faker\Generator as Faker;

$factory->define(Student::class, function (Faker $faker) {
    return [
        'full_name' => $faker->name,
        'nric' => $faker->e164PhoneNumber(),
        'age' => $faker->numberBetween(5, 18),
        'level' => $faker->numberBetween(1,14),
        'mobile_no' => $faker->e164PhoneNumber(),
        'date_joined'=> now(),
        'branch_id' => $faker->numberBetween(1,2),
    ];
});
