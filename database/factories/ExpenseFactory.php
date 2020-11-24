<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Expense;
use Faker\Generator as Faker;

$factory->define(Expense::class, function (Faker $faker) {
    return [
        'expense_date' => now(),
        'amount' => $faker->numberBetween(50, 120),
        'expense_category_id' => $faker->numberBetween(1, 4),
        'branch_id' => $faker->numberBetween(1,2)
    ];
});
