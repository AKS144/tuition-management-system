<?php

use Illuminate\Database\Seeder;
use App\MenuList;

class MenuListSeeder extends Seeder
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
                'title' => 'Dashboard',
                'url' => 'dashboard',
                'icon' => 'firestore',
                'is_active' => '1',
                'is_collapsible' => '0',
                'menu_id' => '1',
            ],
            [
                'title' => 'Media',
                'url' => 'upload',
                'icon' => 'camera-retro',
                'is_active' => '1',
                'is_collapsible' => '1',
                'menu_id' => '2',
            ],
            [
                'title' => 'Users',
                'url' => 'user',
                'icon' => 'spannar',
                'is_active' => '1',
                'is_collapsible' => '1',
                'menu_id' => '3',
            ],
            [
                'title' => 'Archive',
                'url' => 'archive',
                'icon' => 'gear',
                'is_active' => '1',
                'is_collapsible' => '0',
                'menu_id' => '3',
            ],
            [
                'title' => 'Profile',
                'url' => 'profile',
                'icon' => 'gear',
                'is_active' => '1',
                'is_collapsible' => '0',
                'menu_id' => '3',
            ],
            [
                'title' => 'Logout',
                'url' => 'logout',
                'icon' => 'gear',
                'is_active' => '1',
                'is_collapsible' => '0',
                'menu_id' => '4',
            ],
        ];

        foreach($menu as $key => $value) {
            MenuList::create($value);
        }
    }
}
