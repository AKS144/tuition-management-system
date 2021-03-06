<?php

use Illuminate\Database\Seeder;
use App\Address;
use App\BranchSetting;
use App\User;

class BranchSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::find(1);

        // $address = Address::create(['addressable_id' => 1, 'addressable_type' => 'App\Branch']);
        // $address = Address::create(['addressable_id' => 2, 'addressable_type' => 'App\Branch']);
        // $address = Address::create(['addressable_id' => 1, 'addressable_type' => "App\Parents"]);

        $sets = [
            'currency'           => 1,
            'time_zone'          => 'UTC',
            'language'           => 'en',
            'notification_email' =>  $user->email,
            'fiscal_year'        => '1-12',
            'carbon_date_format' => 'd M Y',
            'moment_date_format' => 'DD MMM YYYY'
        ];

        foreach ($sets as $key => $value) {
            BranchSetting::setSetting(
                $key,
                $value,
                1
            );
        }
    }
}
