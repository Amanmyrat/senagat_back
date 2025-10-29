<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::firstOrCreate(
            ['email' => 'admin1@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('12345678'),
            ]
        );

        $role = Role::firstOrCreate([
            'name' => 'super_admin',
            'guard_name' => 'admin',
        ]);

        $permissions = Permission::all();

        if ($permissions->isEmpty()) {

            $permissions = collect([
                'view_any_role', 'create_role', 'update_role', 'delete_role',
                'view_any_user', 'create_user', 'update_user', 'delete_user',

            ])->map(fn ($name) => Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'admin',
            ]));
        }

        $role->syncPermissions($permissions);

        $admin->assignRole($role);

        $admin->givePermissionTo($permissions);

        $this->command->info('✅ Super Admin created successfully!');
    }
}
