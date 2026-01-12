<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $staffRole = Role::where('name', 'staff')->first();

        $permissions = Permission::all();

        //Admin có toàn quyền
        $adminRole->permissions()->sync($permissions);

        //nhân viên có 3 quyền
        $staffPermissions = $permissions->whereIn('name', [
            'manage_products',
            'manage_orders',
            'manage_contacts'
        ]);
        $staffRole->permissions()->sync($staffPermissions);
    }
}
