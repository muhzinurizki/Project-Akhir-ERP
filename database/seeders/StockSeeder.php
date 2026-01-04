<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ProductWarehouse;
use App\Models\StockMutation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data dasar
        $products = Product::all();
        $warehouses = Warehouse::all();
        $admin = User::first(); // User yang mencatat transaksi

        if ($products->isEmpty() || $warehouses->isEmpty()) {
            $this->command->warn("Pastikan tabel products dan warehouses sudah ada isinya!");
            return;
        }

        DB::beginTransaction();
        try {
            foreach ($products as $product) {
                // Pilih 1-2 gudang secara acak untuk setiap produk
                $randomWarehouses = $warehouses->random(rand(1, 2));

                foreach ($randomWarehouses as $warehouse) {
                    $initialStock = rand(50, 200);

                    // A. Update/Create Saldo di Tabel ProductWarehouse
                    ProductWarehouse::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'warehouse_id' => $warehouse->id,
                        ],
                        ['quantity' => $initialStock]
                    );

                    // B. Catat Riwayat Mutasi (Stock In Pertama)
                    StockMutation::create([
        'item_id'        => $product->id, // GANTI 'product_id' MENJADI 'item_id'
        'warehouse_id'   => $warehouse->id,
        'user_id'        => $admin->id,
        'mutation_type'  => 'IN',
        'qty'            => $initialStock,
        'balance_before' => 0,
        'balance_after'  => $initialStock,
        'reference_type' => 'INITIAL_STOCK',
        'reference_id'   => null,
        'description'    => 'Saldo awal sistem',
        'created_at'     => now()->subDays(rand(5, 10)),
    ]);

                    // C. Tambahkan Mutasi Keluar Acak (Simulasi Penjualan/Pemakaian)
                    $outQty = rand(5, 20);
                    $currentStock = $initialStock - $outQty;

                    StockMutation::create([
        'item_id'        => $product->id, // GANTI 'product_id' MENJADI 'item_id'
        'warehouse_id'   => $warehouse->id,
        'user_id'        => $admin->id,
        'mutation_type'  => 'IN',
        'qty'            => $initialStock,
        'balance_before' => 0,
        'balance_after'  => $initialStock,
        'reference_type' => 'INITIAL_STOCK',
        'reference_id'   => null,
        'description'    => 'Saldo awal sistem',
        'created_at'     => now()->subDays(rand(5, 10)),
    ]);

                    // Update kembali saldo akhir setelah simulasi OUT
                    ProductWarehouse::where('product_id', $product->id)
                        ->where('warehouse_id', $warehouse->id)
                        ->update(['quantity' => $currentStock]);
                }
            }

            DB::commit();
            $this->command->info("Seeder stok dan mutasi berhasil dijalankan!");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Gagal seeding: " . $e->getMessage());
        }
    }
}