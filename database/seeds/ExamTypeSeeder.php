<?php

use Illuminate\Database\Seeder;
use App\ExamType;

class ExamTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $examType = [
            [
                'name' => 'MCQ',
            ],
            [
                'name' => 'Fill in the blanks',
            ],
            [
                'name' => 'Open Book',
            ],
            [
                'name' => 'Essay',
            ],
            [
                'name' => 'MCQ and Essay',
            ],
            [
                'name' => 'True/False',
            ],
        ];

        foreach($examType as $key => $value) {
            ExamType::create($value);
        }
    }
}
