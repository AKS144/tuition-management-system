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
            StudentSeeder::class,
            TutorSeeder::class,
            ParentSeeder::class,
            PackageSeeder::class,
            LevelSeeder::class,
            SubjectSeeder::class,
            ExamTypeSeeder::class,
        ]);

        // // Get all the roles attaching to each user
        // $roles = App\Role::all();

        // // Populate user_roles table
        // App\User::all()->each(function ($user) use ($roles) {
        //     $user->roles()->attach(
        //         $roles->random(rand(1, 3))->pluck('id')->toArray()
        //     );
        // });
    }
}
