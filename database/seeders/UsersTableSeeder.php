<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Tran Quoc Phu',
            'email' => 'tquocphu@example.com',
            'password' => bcrypt('12345678'),
            'phone_number' => '0123456789',
            'status' => 'pending',
            'avatar' => '',
            'address' => 'Tra Vinh, Viet Nam',
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'Bui Dang Khanh',
            'email' => 'bdangkhanh@example.com',
            'password' => bcrypt('12345678'),
            'phone_number' => '0123456798',
            'status' => 'pending',
            'avatar' => '',
            'address' => 'Vinh Long, Viet Nam',
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::create([
            'name' => 'Bui An Binh',
            'email' => 'banbinh@example.com',
            'password' => bcrypt('12345678'),
            'phone_number' => '0914263204',
            'status' => 'pending',
            'avatar' => '',
            'address' => 'Tra Vinh, Viet Nam',
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
