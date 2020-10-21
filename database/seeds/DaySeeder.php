<?php

use Illuminate\Database\Seeder;
use App\Day;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = [
            [
                'name' => 'Monday',
            ],
            [
                'name' => 'Tuesday',
            ],
            [
                'name' => 'Wednesday',
            ],
            [
                'name' => 'Thursday',
            ],
            [
                'name' => 'Friday',
            ],
            [
                'name' => 'Saturday',
            ],
            [
                'name' => 'Sunday',
            ],
        ];

        foreach($days as $key => $value) {
            Day::create($value);
        }
    }
}
