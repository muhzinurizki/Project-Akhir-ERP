<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'PT. Garmen Indo Jaya',
                'contact' => '021-55667788',
                'address' => 'Kawasan Industri Jababeka II, Cikarang, Bekasi, Jawa Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toko Kain Makmur Abadi',
                'contact' => '081299887766',
                'address' => 'Blok B Lantai Dasar No. 12, Pasar Tanah Abang, Jakarta Pusat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Butik Syari Humaira',
                'contact' => '087822334455',
                'address' => 'Jl. Braga No. 45, Bandung, Jawa Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV. Tekstil Mandiri (Distributor)',
                'contact' => '031-77889900',
                'address' => 'Kawasan Industri Rungkut, Surabaya, Jawa Timur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Local Brand "Urban Wear"',
                'contact' => '081122334455',
                'address' => 'Jl. Senopati No. 88, Kebayoran Baru, Jakarta Selatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Garmen Export Sejahtera',
                'contact' => '024-66778899',
                'address' => 'Kawasan Industri Wijayakusuma, Semarang, Jawa Tengah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('customers')->insert($customers);
    }
}