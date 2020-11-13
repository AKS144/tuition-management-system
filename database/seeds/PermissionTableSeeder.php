<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'role-list',
            'role-create',
            'role-delete',
            'role-edit',

            'student-list',
            'student-create',
            'student-delete',
            'student-edit',

            'tutor-list',
            'tutor-create',
            'tutor-delete',
            'tutor-edit',

            'user-list',
            'user-create',
            'user-delete',
            'user-edit',

            'unit-list',
            'unit-create',
            'unit-delete',
            'unit-edit',

            'taxtype-list',
            'taxtype-create',
            'taxtype-delete',
            'taxtype-edit',

            'paymentMethod-list',
            'paymentMethod-create',
            'paymentMethod-delete',
            'paymentMethod-edit',

            'expenseCategory-list',
            'expenseCategory-create',
            'expenseCategory-delete',
            'expenseCategory-edit',

            'invoice-list',
            'invoice-create',
            'invoice-delete',
            'invoice-edit',

            'expense-list',
            'expense-create',
            'expense-delete',
            'expense-edit',

            'payment-list',
            'payment-create',
            'payment-delete',
            'payment-edit',
        ];

        foreach($permissions as $permission){
            Permission::create(['name' => $permission]);
        }

        // // create roles and assign created permissions
        $role = Role::findByName('superadmin');
        $role->givePermissionTo(Permission::all());  // Superadmin have all permission

        $role = Role::findByName('admin');
        $role->givePermissionTo([
            'role-list',
            'role-edit',

            'tutor-list',
            'tutor-create',
            'tutor-delete',
            'tutor-edit',

            'user-list',
            'user-create',
            'user-delete',
            'user-edit',

            'student-list',
            'student-create',
            'student-delete',
            'student-edit',

            'unit-list',
            'unit-create',
            'unit-delete',
            'unit-edit',

            'taxtype-list',
            'taxtype-create',
            'taxtype-delete',
            'taxtype-edit',

            'paymentMethod-list',
            'paymentMethod-create',
            'paymentMethod-delete',
            'paymentMethod-edit',

            'expenseCategory-list',
            'expenseCategory-create',
            'expenseCategory-delete',
            'expenseCategory-edit',

            'invoice-list',
            'invoice-create',
            'invoice-delete',
            'invoice-edit',

            'expense-list',
            'expense-create',
            'expense-delete',
            'expense-edit',

            'payment-list',
            'payment-create',
            'payment-delete',
            'payment-edit',
        ]);

        $role = Role::findByName('manager');
        $role->givePermissionTo([
            'tutor-list',
            'tutor-create',
            'tutor-delete',
            'tutor-edit',

            'user-list',

            'student-list',
            'student-create',
            'student-delete',
            'student-edit',

            'unit-list',
            'unit-create',
            'unit-delete',
            'unit-edit',

            'taxtype-list',
            'taxtype-create',
            'taxtype-delete',
            'taxtype-edit',

            'paymentMethod-list',
            'paymentMethod-create',
            'paymentMethod-delete',
            'paymentMethod-edit',

            'expenseCategory-list',
            'expenseCategory-create',
            'expenseCategory-delete',
            'expenseCategory-edit',

            'invoice-list',
            'invoice-create',
            'invoice-delete',
            'invoice-edit',

            'expense-list',
            'expense-create',
            'expense-delete',
            'expense-edit',

            'payment-list',
            'payment-create',
            'payment-delete',
            'payment-edit',
        ]);

        $role = Role::findByName('staff');
        $role->givePermissionTo([
            'tutor-list',
            'tutor-create',
            'tutor-delete',
            'tutor-edit',

            'user-list',

            'student-list',
            'student-create',
            'student-delete',
            'student-edit',
            
            'unit-list',
            'unit-edit',

            'taxtype-list',
            'taxtype-edit',

            'paymentMethod-list',

            'expenseCategory-list',
            'expenseCategory-edit',

            'invoice-list',
            'invoice-create',
            'invoice-edit',

            'expense-list',
            'expense-create',
            'expense-edit',

            'payment-list',
            'payment-create',
            'payment-edit',
        ]);
    }
}
