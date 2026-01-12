<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'manage_users',
            'manage_products',
            'manage_orders',
            'manage_categories',
            'manage_contacts',
            'manage_coupons'
        ];

        foreach($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
