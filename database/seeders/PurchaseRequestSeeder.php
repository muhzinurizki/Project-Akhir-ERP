<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\User;

class PurchaseRequestSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $warehouse = Warehouse::first();
        $products = Product::take(2)->get();

        if (!$user || !$warehouse || $products->isEmpty()) {
            throw new \RuntimeException(
                'PurchaseRequestSeeder gagal: master data belum lengkap.'
            );
        }

        DB::transaction(function () use ($user, $warehouse, $products) {

            /**
             * ======================================================
             * 1. UPSERT PURCHASE REQUEST
             * ======================================================
             */
            $pr = PurchaseRequest::updateOrCreate(
                ['pr_number' => 'PR-DEMO-001'],
                [
                    'request_date' => now()->toDateString(),
                    'warehouse_id' => $warehouse->id,
                    'status' => 'DRAFT',
                    'requested_by' => $user->id,
                    'note' => 'Seeder PR - kebutuhan awal',
                ]
            );

            /**
             * ======================================================
             * 2. RESET ITEM (IDEMPOTENT)
             * ======================================================
             */
            PurchaseRequestItem::where('purchase_request_id', $pr->id)->delete();

            /**
             * ======================================================
             * 3. INSERT ITEM (DETERMINISTIC)
             * ======================================================
             */
            foreach ($products as $index => $product) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $pr->id,
                    'product_id' => $product->id,
                    'quantity' => match ($index) {
                        0 => 50,
                        1 => 30,
                        default => 10,
                    },
                    'note' => 'Seeder item',
                ]);
            }

            Log::info('PurchaseRequestSeeder executed', [
                'pr_number' => $pr->pr_number,
                'items' => $products->count(),
            ]);
        });
    }
}
