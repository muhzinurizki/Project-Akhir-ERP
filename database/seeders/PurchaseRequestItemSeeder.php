<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Product;

class PurchaseRequestItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            /**
             * ======================================================
             * 1. AMBIL PURCHASE REQUEST
             * ======================================================
             */
            $pr = PurchaseRequest::whereIn('status', ['DRAFT', 'SUBMITTED', 'APPROVED'])
                ->first();

            if (!$pr) {
                throw new \RuntimeException(
                    'PurchaseRequestItemSeeder: Tidak ada Purchase Request yang bisa diisi item.'
                );
            }

            /**
             * ======================================================
             * 2. AMBIL PRODUK (RAW / SEMI BIASANYA)
             * ======================================================
             */
            $products = Product::whereIn('type', ['raw_material', 'semi_finished'])
                ->take(3)
                ->get();

            if ($products->isEmpty()) {
                throw new \RuntimeException(
                    'PurchaseRequestItemSeeder: Produk belum tersedia.'
                );
            }

            /**
             * ======================================================
             * 3. RESET ITEM (AGAR IDEMPOTENT)
             * ======================================================
             */
            PurchaseRequestItem::where('purchase_request_id', $pr->id)->delete();

            /**
             * ======================================================
             * 4. INSERT ITEM
             * ======================================================
             */
            foreach ($products as $index => $product) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $pr->id,
                    'product_id' => $product->id,
                    'quantity' => match ($index) {
                        0 => 100,
                        1 => 50,
                        default => 25,
                    },
                ]);
            }

            Log::info('PurchaseRequestItemSeeder executed', [
                'purchase_request_id' => $pr->id,
                'items' => $products->count(),
            ]);
        });
    }
}
