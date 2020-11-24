<?php

use Illuminate\Database\Seeder;
use App\ExpenseCategory;

class ExpenseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $expenseCategories = [
            [
                'name' => 'Utilities'
            ],
            [
                'name' => 'Food and Beverages'
            ],
            [
                'name' => 'Stationeries'
            ],
            [
                'name' => 'Rental'
            ]
        ];

        foreach ($expenseCategories as $key => $value) {
            ExpenseCategory::create($value);
        }
    }
}
