<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Unit;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Matikan foreign key check untuk proses truncate yang aman
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Schema::enableForeignKeyConstraints();

        DB::transaction(function () {
            // Ambil master data untuk relasi
            $categories = ProductCategory::whereIn('code', ['RAW', 'SEMI', 'FIN'])
                ->get()
                ->keyBy('code');

            $units = Unit::whereIn('code', ['KG', 'MTR', 'PCS'])
                ->get()
                ->keyBy('code');

            // Proteksi jika master data kategori/unit belum di-seed
            if ($categories->count() < 3 || $units->count() < 3) {
                throw new \RuntimeException(
                    'ProductSeeder gagal: Master data (Category/Unit) belum lengkap. Jalankan UnitSeeder dan CategorySeeder dulu.'
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
                 * RAW MATERIAL — BENANG & KIMIA (Unit: KG)
                 * ===================================================== */
                ['sku'=>'YRN-C20S-WHT','name'=>'Yarn Cotton Combed 20s','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','purchase_price'=>45000,'selling_price'=>0,'specification'=>'100% Cotton, White AAA Grade','stock'=>500,'is_active'=>true],
                ['sku'=>'YRN-C30S-WHT','name'=>'Yarn Cotton Combed 30s','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','purchase_price'=>48000,'selling_price'=>0,'specification'=>'100% Cotton, White AAA Grade','stock'=>1200,'is_active'=>true],
                ['sku'=>'YRN-P20S-BLK','name'=>'Yarn Polyester 20s Black','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','purchase_price'=>32000,'selling_price'=>0,'specification'=>'100% Polyester','stock'=>300,'is_active'=>true],
                
                ['sku'=>'DYE-REAC-BLU','name'=>'Reactive Dye Blue','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','purchase_price'=>125000,'selling_price'=>0,'specification'=>'For cotton fabric, High solubility','stock'=>50,'is_active'=>true],
                ['sku'=>'CHEM-SOFT-01','name'=>'Fabric Softener','product_category_id'=>$RAW,'unit_id'=>$KG,'type'=>'raw_material','purchase_price'=>15000,'selling_price'=>0,'specification'=>'Eco-friendly soft finish','stock'=>100,'is_active'=>true],

                /* =====================================================
                 * RAW MATERIAL — AKSESORIS (Unit: PCS)
                 * ===================================================== */
                ['sku'=>'ACC-BTN-WHT','name'=>'Button Standard White','product_category_id'=>$RAW,'unit_id'=>$PCS,'type'=>'raw_material','purchase_price'=>150,'selling_price'=>0,'specification'=>'Plastic 11mm','stock'=>10000,'is_active'=>true],
                ['sku'=>'ACC-ZIP-BLK','name'=>'YKK Zipper Black 15cm','product_category_id'=>$RAW,'unit_id'=>$PCS,'type'=>'raw_material','purchase_price'=>2500,'selling_price'=>0,'specification'=>'Metal teeth','stock'=>500,'is_active'=>true],

                /* =====================================================
                 * SEMI FINISHED — GREY FABRIC (Unit: MTR)
                 * ===================================================== */
                ['sku'=>'FAB-GRY-20S','name'=>'Grey Fabric Cotton 20s','product_category_id'=>$SEMI,'unit_id'=>$MTR,'type'=>'semi_finished','purchase_price'=>35000,'selling_price'=>42000,'specification'=>'Width 72", GSM 160, Single Jersey','stock'=>2000,'is_active'=>true],
                ['sku'=>'FAB-GRY-30S','name'=>'Grey Fabric Cotton 30s','product_category_id'=>$SEMI,'unit_id'=>$MTR,'type'=>'semi_finished','purchase_price'=>38000,'selling_price'=>46000,'specification'=>'Width 72", GSM 140, Single Jersey','stock'=>1500,'is_active'=>true],

                /* =====================================================
                 * FINISHED GOODS — FABRIC (Unit: MTR)
                 * ===================================================== */
                ['sku'=>'FAB-FIN-30S-BLK','name'=>'Finished Fabric 30s Black','product_category_id'=>$FIN,'unit_id'=>$MTR,'type'=>'finished_goods','purchase_price'=>65000,'selling_price'=>95000,'specification'=>'Reactive dyed, Super soft finish','stock'=>500,'is_active'=>true],
                ['sku'=>'FAB-FIN-30S-NVY','name'=>'Finished Fabric 30s Navy','product_category_id'=>$FIN,'unit_id'=>$MTR,'type'=>'finished_goods','purchase_price'=>66000,'selling_price'=>96000,'specification'=>'Reactive dyed, Anti-shrink','stock'=>300,'is_active'=>true],

                /* =====================================================
                 * FINISHED GOODS — APPAREL (Unit: PCS)
                 * ===================================================== */
                ['sku'=>'TSH-PLN-BLK-M','name'=>'T-Shirt Basic Black M','product_category_id'=>$FIN,'unit_id'=>$PCS,'type'=>'finished_goods','purchase_price'=>45000,'selling_price'=>120000,'specification'=>'Cotton Combed 30s, Regular Fit','stock'=>50,'is_active'=>true],
                ['sku'=>'TSH-PLN-BLK-L','name'=>'T-Shirt Basic Black L','product_category_id'=>$FIN,'unit_id'=>$PCS,'type'=>'finished_goods','purchase_price'=>47000,'selling_price'=>125000,'specification'=>'Cotton Combed 30s, Regular Fit','stock'=>75,'is_active'=>true],
                ['sku'=>'POLO-COT-NVY','name'=>'Polo Shirt Premium Navy','product_category_id'=>$FIN,'unit_id'=>$PCS,'type'=>'finished_goods','purchase_price'=>85000,'selling_price'=>175000,'specification'=>'Pique Cotton 24s, Ribbed collar','stock'=>30,'is_active'=>true],
            ];

            foreach ($products as $product) {
                Product::create($product);
            }

            Log::info('ProductSeeder: Data berhasil direset dan diisi ulang.', [
                'count' => count($products),
            ]);
        });
    }
}