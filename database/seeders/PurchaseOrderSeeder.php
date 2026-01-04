<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Models\PurchaseOrder;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $pr = PurchaseRequest::where('status', 'APPROVED')->first();

            if (!$pr) {
                throw new \RuntimeException('PO Seeder: Tidak ada PR APPROVED.');
            }

            $supplier = Supplier::first();

            if (!$supplier) {
                throw new \RuntimeException('PO Seeder: Supplier belum tersedia.');
            }

            PurchaseOrder::updateOrCreate(
                ['po_number' => 'PO-DEMO-001'],
                [
                    'po_date' => now()->toDateString(),
                    'purchase_request_id' => $pr->id,
                    'supplier_id' => $supplier->id,
                    'warehouse_id' => $pr->warehouse_id,
                    'status' => 'DRAFT',
                    'total_qty' => 0,      // akan dihitung ulang oleh ItemSeeder
                    'total_amount' => 0,   // akan dihitung ulang oleh ItemSeeder
                    'created_by' => 1,
                ]
            );

            Log::info('PurchaseOrderSeeder executed', [
                'po_number' => 'PO-DEMO-001',
            ]);
        });
    }
}
