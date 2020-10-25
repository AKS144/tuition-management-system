<?php

use Illuminate\Database\Seeder;
use App\Classroom;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = [
            [
                'name' => 'Sejarah 1A',
                'code' => 'SEJ1A',
                'batch_year' => '2020',
                'tutor_id' => '1',
            ],
            [
                'name' => 'Sejarah 2B',
                'code' => 'SEJ2B',
                'batch_year' => '2020',
                'tutor_id' => '2',
            ],
            [
                'name' => 'Biologi 1A',
                'code' => 'BIO1A',
                'batch_year' => '2020',
                'tutor_id' => '3',
            ],
            [
                'name' => 'Biologi 2A',
                'code' => 'BIO2A',
                'batch_year' => '2020',
                'tutor_id' => '4',
            ],
            [
                'name' => 'Fizik 1A',
                'code' => 'FIZ1A',
                'batch_year' => '2020',
                'tutor_id' => '2',
            ],
            [
                'name' => 'Fizik 2A',
                'code' => 'FIZ2A',
                'batch_year' => '2020',
                'tutor_id' => '6',
            ],
        ];

        foreach($class as $key => $value) {
            Classroom::create($value);
        }
    }
}
