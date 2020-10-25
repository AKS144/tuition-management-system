<?php

use Illuminate\Database\Seeder;
use App\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $package = [
            [
                'name' => '1 Subjek',
                'amount' => '45',
                'type' => 'Pakej UPSR',
            ],
            [
                'name' => '2 Subjek',
                'amount' => '85',
                'type' => 'Pakej UPSR',
            ],
            [
                'name' => '3 Subjek',
                'amount' => '120',
                'type' => 'Pakej UPSR',
            ],
            [
                'name' => '4 Subjek',
                'amount' => '130',
                'type' => 'Pakej UPSR',
            ],
            [
                'name' => '5 Subjek',
                'amount' => '150',
                'type' => 'Pakej UPSR',
            ],
            [
                'name' => '6 Subjek',
                'amount' => '160',
                'type' => 'Pakej UPSR',
            ],
            [
                'name' => '7 Subjek',
                'amount' => '170',
                'type' => 'Pakej UPSR',
            ],
            [
                'name' => '8 Subjek',
                'amount' => '180',
                'type' => 'Pakej UPSR',
            ],

            [
                'name' => '1 Subjek',
                'amount' => '50',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => 'B.Arab Pakej',
                'amount' => '35',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => 'B.Arab Bukan Pakej',
                'amount' => '75',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '2 Subjek',
                'amount' => '90',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '3 Subjek',
                'amount' => '150',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '4 Subjek',
                'amount' => '170',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '5 Subjek',
                'amount' => '180',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '6 Subjek',
                'amount' => '200',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '7 Subjek',
                'amount' => '220',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '8 Subjek',
                'amount' => '240',
                'type' => 'Pakej PT3',
            ],
            [
                'name' => '9 Subjek',
                'amount' => '250',
                'type' => 'Pakej PT3',
            ],

            [
                'name' => '1 Subjek',
                'amount' => '50',
                'type' => 'Pakej SPM (Sastera)',
            ],
            [
                'name' => '1 Subjek',
                'amount' => '55',
                'type' => 'Pakej SPM (Sains)',
            ],
        ];

        foreach($package as $key => $value) {
            Package::create($value);
        }
    }
}
