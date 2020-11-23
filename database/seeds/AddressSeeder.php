<?php

use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Address')->create(['addressable_id' => 1, 'addressable_type' => 'App\Branch']);
        factory('App\Address')->create(['addressable_id' => 2, 'addressable_type' => 'App\Branch']);
        factory('App\Address')->create(['addressable_id' => 1, 'addressable_type' => "App\Parents"]);
    }
}
