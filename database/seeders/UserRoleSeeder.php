<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset Cache Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Bersihkan Tabel (Hati-hati: Menghapus semua user lama)
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 3. Definisi Data Role & User Default
        $data = [
            [
                'role' => 'Admin',
                'user' => [
                    'name'     => 'System Administrator',
                    'email'    => 'admin@erp.test',
                    'username' => 'admin',
                    'code'     => 'EMP-001'
                ]
            ],
            [
                'role' => 'Manager',
                'user' => [
                    'name'     => 'Operations Manager',
                    'email'    => 'manager@erp.test',
                    'username' => 'manager',
                    'code'     => 'EMP-002'
                ]
            ],
            [
                'role' => 'Purchasing',
                'user' => [
                    'name'     => 'Purchasing Staff',
                    'email'    => 'purchasing@erp.test',
                    'username' => 'purchasing',
                    'code'     => 'EMP-003'
                ]
            ],
            [
                'role' => 'Warehouse',
                'user' => [
                    'name'     => 'Warehouse Keeper',
                    'email'    => 'warehouse@erp.test',
                    'username' => 'warehouse',
                    'code'     => 'EMP-004'
                ]
            ],
            [
                'role' => 'Sales',
                'user' => [
                    'name'     => 'Sales Executive',
                    'email'    => 'sales@erp.test',
                    'username' => 'sales',
                    'code'     => 'EMP-005'
                ]
            ],
            [
                'role' => 'Finance',
                'user' => [
                    'name'     => 'Finance & Accounting',
                    'email'    => 'finance@erp.test',
                    'username' => 'finance',
                    'code'     => 'EMP-006'
                ]
            ],
        ];

        foreach ($data as $item) {
            // A. Buat atau Pastikan Role Ada
            $role = Role::firstOrCreate(['name' => $item['role'], 'guard_name' => 'web']);

            // B. Buat User
            $user = User::create([
                'name'              => $item['user']['name'],
                'email'             => $item['user']['email'],
                'username'          => $item['user']['username'],
                'employee_code'     => $item['user']['code'],
                'password'          => Hash::make('password'),
                'is_active'         => true,
                'email_verified_at' => now(),
            ]);

            // C. Pasangkan Role ke User
            $user->assignRole($role);
        }

        $this->command->info('Roles and Users seeded successfully!');
        $this->command->warn('All passwords are: password');
    }
}