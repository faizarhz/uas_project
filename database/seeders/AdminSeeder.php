<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@beverly.com'],
            [
                'name' => 'Admin Beverly',
                'phone' => '081234567890',
                'password' => Hash::make('AdminBeverly123'),
                'role' => 'admin',
            ]
        );
    }
}
