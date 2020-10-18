<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'role' => 'Super Admin',
            ],
            [
                'role' => 'Branch Manager',
            ],
            [
                'role' => 'Staff',
            ],
        ];

        foreach($roles as $key => $value) {
            Role::create($value);
        }
    }
}
