<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@erp.test'],
            [
                'name' => 'System Admin',
                'username' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('Admin');
    }
}
