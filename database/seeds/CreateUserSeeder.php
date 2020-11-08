<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'full_name'=>'Admin Saiful',
                'email'=>'saiful@admin.com',
                'is_active'=>'1',
                // 'role_id' => '1',
                'password' => bcrypt('Asd1234'),
            ],
            [
                'full_name' => 'Admin Malik',
                'email' => 'malik@admin.com',
                'is_active' => '1',
                // 'role_id' => '1',
                'password' => bcrypt('Asd1234'),
            ],
        ];

        foreach($user as $key => $value) {
            $user = User::create($value);
            $user->assignRole('superadmin');
        }
    }
}
