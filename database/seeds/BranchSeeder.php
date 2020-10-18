<?php

use Illuminate\Database\Seeder;
use App\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Pusat Tuisyen Fikir Jaya',
                'address' => 'No 27, Tingkat 1, Jalan Seroja 3, Taman Seroja, Bandar Baru Salak Tinggi, 43900 Sepang, Selangor',
                'city' => 'Selangor',
            ],
            [
                'name' => 'Pusat Tuisyen Faiza Jaya',
                'address' => 'No 27, Tingkat 1, Jalan Seroja 3, Taman Seroja, Bandar Baru Salak Tinggi, 43900 Sepang, Selangor',
                'city' => 'Selangor',
            ],
        ];

        foreach($roles as $key => $value) {
            Branch::create($value);
        }
    }
}
