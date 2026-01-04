<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Unit;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $categories = ProductCategory::whereIn('code', ['RAW', 'SEMI', 'FIN'])
                ->get()
                ->keyBy('code');

            $units = Unit::whereIn('code', ['KG', 'MTR', 'PCS'])
                ->get()
                ->keyBy('code');

            if ($categories->count() < 3 || $units->count() < 3) {
                throw new \RuntimeException(
                    'ProductSeeder gagal: master data belum lengkap.'
                );
            }

            $RAW  = $categories['RAW']->id;
            $SEMI = $categories['SEMI']->id;
            $FIN  = $categories['FIN']->id;

            $KG  = $units['KG']->id;
            $MTR = $units['MTR']->id;
            $PCS = $units['PCS']->id;

            $products = [

                /* =====================================================
                 * RAW MATERIAL — BENANG
                 * ===================================================== */
                ['sku'=>'YRN-C20S-WHT','name'=>'Yarn Cotton Combed 20s','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'100% Cotton','is_active'=>true],
                ['sku'=>'YRN-C24S-WHT','name'=>'Yarn Cotton Combed 24s','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'100% Cotton','is_active'=>true],
                ['sku'=>'YRN-C30S-WHT','name'=>'Yarn Cotton Combed 30s','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'100% Cotton','is_active'=>true],
                ['sku'=>'YRN-C40S-WHT','name'=>'Yarn Cotton Combed 40s','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'Fine Yarn','is_active'=>true],

                /* =====================================================
                 * RAW MATERIAL — CHEMICAL & DYE
                 * ===================================================== */
                ['sku'=>'DYE-REAC-BLU','name'=>'Reactive Dye Blue','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'For cotton fabric','is_active'=>true],
                ['sku'=>'DYE-REAC-RED','name'=>'Reactive Dye Red','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'For cotton fabric','is_active'=>true],
                ['sku'=>'CHEM-SOFT-01','name'=>'Fabric Softener','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'Soft finish','is_active'=>true],
                ['sku'=>'CHEM-DET-01','name'=>'Textile Detergent','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','selling_price'=>0,'specification'=>'Pre-wash','is_active'=>true],

                /* =====================================================
                 * SEMI FINISHED — GREY FABRIC
                 * ===================================================== */
                ['sku'=>'FAB-GRY-20S','name'=>'Grey Fabric Cotton 20s','product_category_id'=>$SEMI,'unit_id'=>$MTR,'type'=>'semi_finished','selling_price'=>42000,'specification'=>'Width 72", GSM 160','is_active'=>true],
                ['sku'=>'FAB-GRY-24S','name'=>'Grey Fabric Cotton 24s','product_category_id'=>$SEMI,'unit_id'=>$MTR,'type'=>'semi_finished','selling_price'=>44000,'specification'=>'Width 72", GSM 150','is_active'=>true],
                ['sku'=>'FAB-GRY-30S','name'=>'Grey Fabric Cotton 30s','product_category_id'=>$SEMI,'unit_id'=>$MTR,'type'=>'semi_finished','selling_price'=>46000,'specification'=>'Width 72", GSM 140','is_active'=>true],
                ['sku'=>'FAB-GRY-40S','name'=>'Grey Fabric Cotton 40s','product_category_id'=>$SEMI,'unit_id'=>$MTR,'type'=>'semi_finished','selling_price'=>48000,'specification'=>'Width 72", GSM 130','is_active'=>true],

                /* =====================================================
                 * FINISHED GOODS — FABRIC
                 * ===================================================== */
                ['sku'=>'FAB-FIN-30S-BLK','name'=>'Finished Fabric 30s Black','product_category_id'=>$FIN,'unit_id'=>$MTR,'type'=>'finished_goods','selling_price'=>95000,'specification'=>'Reactive dyed','is_active'=>true],
                ['sku'=>'FAB-FIN-30S-NVY','name'=>'Finished Fabric 30s Navy','product_category_id'=>$FIN,'unit_id'=>$MTR,'type'=>'finished_goods','selling_price'=>96000,'specification'=>'Reactive dyed','is_active'=>true],
                ['sku'=>'FAB-FIN-24S-WHT','name'=>'Finished Fabric 24s White','product_category_id'=>$FIN,'unit_id'=>$MTR,'type'=>'finished_goods','selling_price'=>90000,'specification'=>'Bleached','is_active'=>true],

                /* =====================================================
                 * FINISHED GOODS — APPAREL
                 * ===================================================== */
                ['sku'=>'TSH-PLN-BLK-M','name'=>'T-Shirt Black M','product_category_id'=>$FIN,'unit_id'=>$PCS,'type'=>'finished_goods','selling_price'=>120000,'specification'=>'Cotton 30s','is_active'=>true],
                ['sku'=>'TSH-PLN-BLK-L','name'=>'T-Shirt Black L','product_category_id'=>$FIN,'unit_id'=>$PCS,'type'=>'finished_goods','selling_price'=>125000,'specification'=>'Cotton 30s','is_active'=>true],
                ['sku'=>'TSH-PLN-WHT-M','name'=>'T-Shirt White M','product_category_id'=>$FIN,'unit_id'=>$PCS,'type'=>'finished_goods','selling_price'=>115000,'specification'=>'Cotton 30s','is_active'=>true],
                ['sku'=>'POLO-COT-NVY','name'=>'Polo Shirt Navy','product_category_id'=>$FIN,'unit_id'=>$PCS,'type'=>'finished_goods','selling_price'=>175000,'specification'=>'Pique cotton','is_active'=>true],
            ];

            foreach ($products as $product) {
                Product::updateOrCreate(
                    ['sku' => $product['sku']],
                    $product
                );
            }

            Log::info('ProductSeeder executed', [
                'total' => count($products),
            ]);
        });
    }
}
