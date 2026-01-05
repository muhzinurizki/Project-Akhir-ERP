<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Bersihkan tabel sebelumnya untuk menghindari duplikasi saat seeding ulang
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        // 2. Pastikan Role Admin sudah ada (menggunakan Spatie)
        // Jika Anda belum membuat seeder Role, baris ini memastikan Role 'Admin' tersedia
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // 3. Buat Master Admin
        $admin = User::create([
            'name'          => 'System Administrator',
            'email'         => 'admin@erp.test',
            'username'      => 'admin',
            'employee_code' => 'EMP-2026-0001', // Sesuaikan format dengan sistem generator kita
            'phone'         => '08123456789',
            'password'      => Hash::make('password'), // Selalu gunakan Hash
            'is_active'     => true, // Wajib TRUE agar bisa login
            'email_verified_at' => now(),
        ]);

        // 4. Pasangkan Role ke User
        $admin->assignRole($adminRole);

        $this->command->info('Admin user created successfully: admin@erp.test | password');
    }
}