<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            CreateUserSeeder::class,
            BranchSeeder::class,
            MenuSeeder::class,
            MenuListSeeder::class,
            MenuCollapsibleListSeeder::class,
            DaySeeder::class,
            TimeSlotSeeder::class,
            VenueSeeder::class,
        ]);
    }
}
