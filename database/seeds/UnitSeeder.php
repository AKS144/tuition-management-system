<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = [
            [
                'name' => 'box',
            ],
            [
                'name' => 'cm',
            ],
            [
                'name' => 'dz',
            ],
            [
                'name' => 'ft',
            ],
            [
                'name' => 'g',
            ],
            [
                'name' => 'in',
            ],
            [
                'name' => 'kg',
            ],
            [
                'name' => 'km',
            ],
            [
                'name' => 'lb',
            ],
            [
                'name' => 'mg',
            ],
            [
                'name' => 'pc',
            ],
        ];

        foreach($units as $key => $value) {
            Unit::create($value);
        }
    }
}
