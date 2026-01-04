<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\User;

class StockMovementSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $warehouse = Warehouse::first();

        $product = Product::whereIn('type', ['raw_material', 'semi_finished'])
            ->first();

        if (!$user || !$product || !$warehouse) {
            throw new \RuntimeException(
                'StockMovementSeeder gagal: master data belum lengkap.'
            );
        }

        DB::transaction(function () use ($user, $product, $warehouse) {

            /**
             * ======================================================
             * 1. RESET DATA (IDEMPOTENT)
             * ======================================================
             */
            StockMovement::where('reference', 'INIT-STOCK')->delete();
            StockMovement::where('reference', 'TEST-OUT')->delete();

            /**
             * ======================================================
             * 2. STOCK IN (INITIAL)
             * ======================================================
             */
            StockMovement::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'type' => 'IN',
                'quantity' => 100,
                'reference' => 'INIT-STOCK',
                'note' => 'Initial stock setup (Seeder)',
                'created_by' => $user->id,
            ]);

            /**
             * ======================================================
             * 3. VALIDASI STOCK SEBELUM OUT
             * ======================================================
             */
            $currentStock = StockMovement::where('product_id', $product->id)
                ->where('warehouse_id', $warehouse->id)
                ->sum(DB::raw("
                    CASE
                        WHEN type = 'IN' THEN quantity
                        WHEN type = 'OUT' THEN -quantity
                        ELSE 0
                    END
                "));

            if ($currentStock < 30) {
                throw new \RuntimeException(
                    'StockMovementSeeder gagal: stok tidak mencukupi untuk OUT.'
                );
            }

            /**
             * ======================================================
             * 4. STOCK OUT
             * ======================================================
             */
            StockMovement::create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'type' => 'OUT',
                'quantity' => 30,
                'reference' => 'TEST-OUT',
                'note' => 'Test stock out (Seeder)',
                'created_by' => $user->id,
            ]);

            Log::info('StockMovementSeeder executed', [
                'product_id' => $product->id,
                'warehouse_id' => $warehouse->id,
                'final_stock' => $currentStock - 30,
            ]);
        });
    }
}
