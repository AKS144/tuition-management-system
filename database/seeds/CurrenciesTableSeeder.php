<?php

use Illuminate\Database\Seeder;
use App\Currency;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [
                'name' => 'Malaysian Ringgit',
                'code' => 'MYR',
                'symbol' => 'RM',
                'precision' => '2',
                'thousand_separator' => ',',
                'decimal_separator' => '.'
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
