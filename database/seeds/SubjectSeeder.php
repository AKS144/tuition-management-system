<?php

use Illuminate\Database\Seeder;
use App\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subject = [
            [
                'name' => 'Bahasa Melayu',
                'code' => 'BM',
            ],
            [
                'name' => 'Bahasa Inggeris',
                'code' => 'ENG',
            ],
            [
                'name' => 'Matematik',
                'code' => 'MATH',
            ],
            [
                'name' => 'Sains',
                'code' => 'SN',
            ],
            [
                'name' => 'Sejarah',
                'code' => 'SEJ',
            ],
            [
                'name' => 'Geografi',
                'code' => 'GEO',
            ],
            [
                'name' => 'Biologi',
                'code' => 'BIO',
            ],
            [
                'name' => 'Kimia',
                'code' => 'CHE',
            ],
            [
                'name' => 'FIZIK',
                'code' => 'PHY',
            ],
            [
                'name' => 'Matematik Tambahan',
                'code' => 'ADM',
            ],
            [
                'name' => 'Prinsip Akaun',
                'code' => 'PA',
            ],
            [
                'name' => 'Ekonomi',
                'code' => 'EKO',
            ],
            [
                'name' => 'Perniagaan',
                'code' => 'PNG',
            ],
            [
                'name' => 'Bahasa Arab',
                'code' => 'BA',
            ],
            [
                'name' => 'Pendidikan Islam',
                'code' => 'PI',
            ],
            [
                'name' => 'PQS',
                'code' => 'PQS',
            ],
            [
                'name' => 'PSI',
                'code' => 'PSI',
            ],
            [
                'name' => 'Semarak Jawi',
                'code' => 'SJ',
            ],
            [
                'name' => 'Tasawwur',
                'code' => 'TS',
            ],
            [
                'name' => 'Conversation English',
                'code' => 'CE',
            ],
            [
                'name' => 'Mini Tahfiz Quran',
                'code' => 'MTQ',
            ],
            [
                'name' => 'Quran Dewasa',
                'code' => 'QD',
            ],
            [
                'name' => 'bahasa Arab Dewasa',
                'code' => 'BAD',
            ],
            [
                'name' => 'English Dewasa',
                'code' => 'ED',
            ],
            [
                'name' => 'Intensif Al-Quran',
                'code' => 'IA',
            ],
            [
                'name' => 'Intensif Membaca',
                'code' => 'IM',
            ],
        ];

        foreach($subject as $key => $value) {
            Subject::create($value);
        }
    }
}
