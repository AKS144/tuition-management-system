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
            ClassroomSeeder::class,
        ]);

        // Get all the roles attaching to each menu/menuList
        $roles = App\Role::all();

        // Populate menu_role table
        App\Menu::all()->each(function ($menu) use ($roles) {
            $menu->roles()->attach(
                $roles->random(rand(1, $roles->count()))->pluck('id')->toArray()
            );
        });

        // Popoulate menu_list_role table
        App\MenuList::all()->each(function ($menuList) use ($roles) {
            $menuList->roles()->attach(
                $roles->random(rand(1, $roles->count()))->pluck('id')->toArray()
            );
        });

        // Get all the user attaching to each branch
        $users = App\User::all();

        // Populate branch_user table
        App\Branch::all()->each(function ($branch) use ($users) {
            $branch->users()->attach(
                $users->random(rand(1, $users->count()))->pluck('id')->toArray()
            );
        });

        // Get all the venue attaching to each branch
        $venue = App\Venue::all();

        // Populate branch_venue table
        App\Branch::all()->each(function ($branch) use ($venue) {
            $branch->venues()->attach(
                $venue->random(rand(1, $venue->count()))->pluck('id')->toArray()
            );
        });

        // Get all student attaching to each parent/class/package/payment
        $student = App\Student::all();

        // Populate parent_student table
        App\Parents::all()->each(function ($parent) use ($student) {
            $parent->students()->attach(
                $student->random(rand(1, $student->count()))->pluck('id')->toArray()
            );
        });

        // Get all subject attaching to each level
        $subject = App\Subject::all();

        // Populate subject_level table
        App\Level::all()->each(function ($parent) use ($subject) {
            $parent->subjects()->attach(
                $subject->random(rand(1, $subject->count()))->pluck('id')->toArray()
            );
        });
    }
}
