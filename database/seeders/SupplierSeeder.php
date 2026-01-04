<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $faker = Faker::create('id_ID');

            /**
             * ======================================================
             * 1. DATA UTAMA (FIXED & IDEMPOTENT)
             * ======================================================
             */
            $fixedSuppliers = [
                [
                    'code' => 'SUP-TX-001',
                    'name' => 'PT Indotex Utama Jaya',
                    'contact_person' => 'Budi Santoso',
                    'phone' => '0215551234',
                    'email' => 'sales@indotex.co.id',
                    'address' => 'Kawasan Industri Jababeka, Cikarang',
                    'is_active' => true,
                ],
                [
                    'code' => 'SUP-CH-002',
                    'name' => 'CV Warna Kimia Mandiri',
                    'contact_person' => 'Sari Wijaya',
                    'phone' => '0224445678',
                    'email' => 'info@warnakimia.com',
                    'address' => 'Jl. Moch. Toha No. 45, Bandung',
                    'is_active' => true,
                ],
            ];

            foreach ($fixedSuppliers as $supplier) {
                Supplier::updateOrCreate(
                    ['code' => $supplier['code']],
                    $supplier
                );
            }

            /**
             * ======================================================
             * 2. DATA TAMBAHAN (CONTROLLED RANDOM)
             * ======================================================
             */
            $industries = ['Textile', 'Garment', 'Benang', 'Pewarna', 'Kain', 'Aksesoris', 'Logistik'];
            $suffixes = ['Jaya', 'Makmur', 'Sejahtera', 'Indah', 'Pratama', 'Sentosa', 'Mandiri'];
            $types = ['PT', 'CV', 'UD'];

            for ($i = 1; $i <= 15; $i++) {
                $code = 'SUP-AUTO-' . str_pad($i, 3, '0', STR_PAD_LEFT);

                Supplier::updateOrCreate(
                    ['code' => $code],
                    [
                        'name' => $faker->randomElement($types) . ' ' .
                                  $faker->randomElement($industries) . ' ' .
                                  $faker->randomElement($suffixes),
                        'contact_person' => $faker->name,
                        'phone' => $faker->phoneNumber,
                        'email' => "supplier{$i}@example.com",
                        'address' => $faker->address,
                        'is_active' => true,
                    ]
                );
            }
        });
    }
}
