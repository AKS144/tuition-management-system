<?php

use Illuminate\Database\Seeder;
use App\Menu;

class MenuSeeder extends Seeder
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
                'title' => 'Overall',
            ],
            [
                'title' => 'Interface',
            ],
            [
                'title' => 'Manage',
            ],
            [
                'title' => 'Settings',
            ],
        ];

        foreach($menu as $key => $value) {
            Menu::create($value);
        }
    }
}
