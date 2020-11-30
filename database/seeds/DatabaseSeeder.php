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
            RoleTableSeeder::class,
            CreateUserSeeder::class,
            BranchSeeder::class,
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
            PermissionTableSeeder::class,
            CountriesTableSeeder::class,
            CurrenciesTableSeeder::class,
            InvoiceTemplateSeeder::class,
            PaymentMethodSeeder::class,
            UnitSeeder::class,
            AddressSeeder::class,
            BranchSettingSeeder::class,
            ExpenseCategorySeeder::class,
            ExpenseSeeder::class
        ]);

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
        $parent = App\Parents::all();
        
        // Populate parent_student table
        App\Student::all()->each(function ($student) use ($parent) {
            $student->parents()->attach(
                $parent->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // Get all subject
        $subject = App\Subject::all();

        // Populate subject_level table
        App\Level::all()->each(function ($level) use ($subject) {
            $level->subjects()->attach(
                $subject->random(rand(1, 2))->pluck('id')->toArray()
            );
        });

        // Get all subject level
        $subjectLevel = App\SubjectLevel::all();

        // Populate subject_level_package
        App\Package::all()->each(function ($package) use ($subjectLevel)  {
            $package->subjectLevels()->attach(
                $subjectLevel->random(rand(1,5))->pluck('id')->toArray()
            );
        });
        
        // Populate student_package 
        App\Package::all()->each(function ($package) use ($student) {
            $package->students()->attach(
                $student->random(rand(1,2))->pluck('id')->toArray()
            );
        });

        // Populate classroom_student 
        App\Classroom::all()->each(function ($classroom) use ($student) {
            $classroom->student()->attach(
                $student->random(rand(5,20))->pluck('id')->toArray()
            );
        });
    }
}
