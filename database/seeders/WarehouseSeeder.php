<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /**
             * ======================================================
             * 1. WAREHOUSE UTAMA (FIXED)
             * ======================================================
             */
            $warehouses = [
                [
                    'code' => 'WH-RM-01',
                    'name' => 'Raw Material Warehouse',
                    'address' => 'Area Utara - Gedung A1 (Loading Dock)',
                    'is_active' => true,
                ],
                [
                    'code' => 'WH-WIP-01',
                    'name' => 'Work In Process Warehouse',
                    'address' => 'Lantai 2 - Area Weaving',
                    'is_active' => true,
                ],
                [
                    'code' => 'WH-FG-01',
                    'name' => 'Finished Goods Warehouse',
                    'address' => 'Gedung B - Area Distribusi',
                    'is_active' => true,
                ],
                [
                    'code' => 'WH-TRN-01',
                    'name' => 'Transit Warehouse',
                    'address' => 'Gedung C - Bongkar Muat',
                    'is_active' => true,
                ],
                [
                    'code' => 'WH-REJ-01',
                    'name' => 'Reject & Return Warehouse',
                    'address' => 'Sudut Barat Pabrik',
                    'is_active' => true,
                ],
                [
                    'code' => 'WH-SPP-01',
                    'name' => 'Sparepart & Utility Warehouse',
                    'address' => 'Workshop Maintenance',
                    'is_active' => true,
                ],
            ];

            foreach ($warehouses as $wh) {
                Warehouse::updateOrCreate(
                    ['code' => $wh['code']],
                    $wh
                );
            }

            /**
             * ======================================================
             * 2. WAREHOUSE EKSTERNAL (CONTROLLED)
             * ======================================================
             */
            $externalWarehouses = [
                [
                    'code' => 'WH-EXT-01',
                    'name' => 'External Warehouse Jakarta',
                    'address' => 'Jakarta Timur',
                    'is_active' => true,
                ],
                [
                    'code' => 'WH-EXT-02',
                    'name' => 'External Warehouse Bandung',
                    'address' => 'Bandung',
                    'is_active' => true,
                ],
                [
                    'code' => 'WH-EXT-03',
                    'name' => 'External Warehouse Surabaya',
                    'address' => 'Surabaya',
                    'is_active' => false,
                ],
            ];

            foreach ($externalWarehouses as $ext) {
                Warehouse::updateOrCreate(
                    ['code' => $ext['code']],
                    $ext
                );
            }
        });
    }
}
