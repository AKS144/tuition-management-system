<?php

use Illuminate\Database\Seeder;
use App\TimeSlot;

class TimeSlotSeeder extends Seeder
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
                'start_time' => '20',
                'end_time' => '22',
            ],
            [
                'start_time' => '18',
                'end_time' => '20',
            ],
            [
                'start_time' => '18',
                'end_time' => '19',
            ],
            [
                'start_time' => '20',
                'end_time' => '21',
            ],
            [
                'start_time' => '21',
                'end_time' => '23',
            ],
            [
                'start_time' => '21',
                'end_time' => '22',
            ],
            [
                'start_time' => '8',
                'end_time' => '10',
            ],
        ];

        foreach($days as $key => $value) {
            TimeSlot::create($value);
        }
    }
}
