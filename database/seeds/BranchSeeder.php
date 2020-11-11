<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
        $branch = [
            [
                'name' => 'Pusat Tuisyen Fikir Jaya',
                'city' => 'Selangor',
                'unique_hash' => Str::random(60)
            ],
            [
                'name' => 'Pusat Tuisyen Faiza Jaya',
                'city' => 'Selangor',
                'unique_hash' => Str::random(60)
            ],
        ];

        foreach($branch as $key => $value) {
            Branch::create($value);
        }
    }
}
