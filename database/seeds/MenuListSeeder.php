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
            ],
            [
                'title' => 'Create',
                'url' => '',
                'icon' => 'pencil',
                'is_active' => '1',
                'is_collapsible' => '1',
            ],
            [
                'title' => 'Manage',
                'url' => '',
                'icon' => 'spannar',
                'is_active' => '1',
                'is_collapsible' => '1',
            ],
            [
                'title' => 'Settings',
                'url' => '',
                'icon' => 'gear',
                'is_active' => '1',
                'is_collapsible' => '1',
            ],
        ];

        foreach($menu as $key => $value) {
            MenuList::create($value);
        }
    }
}
