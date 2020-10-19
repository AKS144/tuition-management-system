<?php

use Illuminate\Database\Seeder;
use App\MenuCollapseList;

class MenuCollapsibleListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = [
            [
                'title' => 'New Student',
                'url' => 'student',
                'icon' => 'student',
                'is_active' => '1',
            ],
            [
                'title' => 'New Tutor',
                'url' => 'tutor',
                'icon' => 'tutor',
                'is_active' => '1',
            ],
            [
                'title' => 'New Subject',
                'url' => 'subject',
                'icon' => 'subject',
                'is_active' => '1',
            ],
            [
                'title' => 'New Package',
                'url' => 'package',
                'icon' => 'package',
                'is_active' => '1',
            ],
            [
                'title' => 'New Class',
                'url' => 'class',
                'icon' => 'class',
                'is_active' => '1',
            ],
            [
                'title' => 'New Payment',
                'url' => 'payment',
                'icon' => 'payment',
                'is_active' => '1',
            ],
            [
                'title' => 'New Exam',
                'url' => 'exam',
                'icon' => 'exam',
                'is_active' => '1',
            ],
            [
                'title' => 'New Branch',
                'url' => 'branch',
                'icon' => 'branch',
                'is_active' => '1',
            ],
            [
                'title' => 'New User',
                'url' => 'user',
                'icon' => 'user',
                'is_active' => '1',
            ],
            [
                'title' => 'New Menu',
                'url' => 'menu',
                'icon' => 'menu',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage User',
                'url' => 'user',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage Tutor',
                'url' => 'tutor',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage Class',
                'url' => 'Class',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage Tutor',
                'url' => 'tutor',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage Subject',
                'url' => 'Subject',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage Attendance',
                'url' => 'Attendance',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage Package',
                'url' => 'Package',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Manage Menu',
                'url' => 'Menu',
                'icon' => 'spannar',
                'is_active' => '1',
            ],
            [
                'title' => 'Edit Profile',
                'url' => 'profile',
                'icon' => 'gear',
                'is_active' => '1',
            ],
            [
                'title' => 'Logout',
                'url' => 'logout',
                'icon' => 'gear',
                'is_active' => '1',
            ],
        ];

        foreach($menu as $key => $value) {
            MenuCollapseList::create($value);
        }
    }
}
