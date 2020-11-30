<?php

use Illuminate\Database\Seeder;
use App\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
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
                'name' => 'Utilities',
                'branch_id' => 1,
            ],
            [
                'name' => 'Food and beverages',
                'branch_id' => 1,
            ],
            [
                'name' => 'Rental',
                'branch_id' => 1,
            ],
            [
                'name' => 'Stationeries',
                'branch_id' => 1,
            ],
            [
                'name' => 'Utilities',
                'branch_id' => 2,
            ],
            [
                'name' => 'Food and beverages',
                'branch_id' => 2,
            ],
            [
                'name' => 'Rental',
                'branch_id' => 2,
            ],
            [
                'name' => 'Stationeries',
                'branch_id' => 2,
            ],
        ];

        foreach($expenseCategories as $key => $value){
            ExpenseCategory::create($value);
        }
    }
}
