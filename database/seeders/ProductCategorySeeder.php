<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $categories = [
                [
                    'code' => 'RAW',
                    'name' => 'Raw Material',
                ],
                [
                    'code' => 'SEMI',
                    'name' => 'Semi Finished',
                ],
                [
                    'code' => 'FIN',
                    'name' => 'Finished Goods',
                ],
            ];

            foreach ($categories as $category) {
                ProductCategory::updateOrCreate(
                    ['code' => $category['code']],
                    [
                        'name' => $category['name'],
                    ]
                );
            }

            Log::info('ProductCategorySeeder executed', [
                'total' => count($categories),
            ]);
        });
    }
}
