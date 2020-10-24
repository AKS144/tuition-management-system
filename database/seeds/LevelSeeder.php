<?php

use Illuminate\Database\Seeder;
use App\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $level = [
            [
                'name' => 'Pra-sekolah',
            ],
            [
                'name' => 'Darjah 1',
            ],
            [
                'name' => 'Darjah 2',
            ],
            [
                'name' => 'Darjah 3',
            ],
            [
                'name' => 'Darjah 4',
            ],
            [
                'name' => 'Darjah 5',
            ],
            [
                'name' => 'UPSR',
            ],
            [
                'name' => 'Tingkatan 1',
            ],
            [
                'name' => 'Tingkatan 2',
            ],
            [
                'name' => 'PT3',
            ],
            [
                'name' => 'Tingkatan 4',
            ],
            [
                'name' => 'SPM',
            ],
            [
                'name' => 'STPM',
            ],
        ];

        foreach($level as $key => $value) {
            Level::create($value);
        }
    }
}
