<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::create([
            'code' => 'SALE10',
            'type' => 'percent',
            'value' => 10,
            'min_order_value' => 200000,
            'usage_limit' => 100,
            'used_count' => 0,
            'expires_at' => now()->addDays(30),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Coupon::create([
            'code' => 'FIX50K',
            'type' => 'fixed',
            'value' => 50000,
            'min_order_value' => 300000,
            'usage_limit' => 50,
            'used_count' => 0,
            'expires_at' => now()->addDays(15),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Coupon::create([
            'code' => 'EXPIRED',
            'type' => 'percent',
            'value' => 20,
            'min_order_value' => 100000,
            'usage_limit' => 10,
            'used_count' => 10,
            'expires_at' => now()->subDay(),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
