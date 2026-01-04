<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $units = [
                ['code' => 'KG',  'name' => 'Kilogram'],
                ['code' => 'MTR', 'name' => 'Meter'],
                ['code' => 'PCS', 'name' => 'Pieces'],
                ['code' => 'ROLL','name' => 'Roll'],
            ];

            foreach ($units as $unit) {
                Unit::updateOrCreate(
                    ['code' => $unit['code']],
                    ['name' => $unit['name']]
                );
            }
        });
    }
}
