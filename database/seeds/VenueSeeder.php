<?php

use Illuminate\Database\Seeder;
use App\Venue;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $venue = [
            [
                'name' => 'Bilik 1'
            ],
            [
                'name' => 'Bilik 2'
            ],
            [
                'name' => 'Bilik 3'
            ],
            [
                'name' => 'Bilik 4'
            ],
            [
                'name' => 'Bilik 5'
            ],
            [
                'name' => 'Bilik 6'
            ],
            [
                'name' => 'Bilik 7'
            ],
            [
                'name' => 'Bilik 8'
            ],
        ];

        foreach($venue as $key => $value) {
            Venue::create($value);
        }
    }
}
