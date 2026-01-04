<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;

class PurchaseOrderItemSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {

            $po = PurchaseOrder::where('po_number', 'PO-DEMO-001')->first();

            if (!$po) {
                throw new \RuntimeException('PO Item Seeder: PO tidak ditemukan.');
            }

            $pr = PurchaseRequest::with('items.product')
                ->find($po->purchase_request_id);

            if (!$pr || $pr->items->isEmpty()) {
                throw new \RuntimeException('PO Item Seeder: PR item tidak tersedia.');
            }

            // Reset item agar idempotent
            PurchaseOrderItem::where('purchase_order_id', $po->id)->delete();

            $totalQty = 0;
            $totalAmount = 0;

            foreach ($pr->items as $item) {

                // Snapshot harga (simulasi)
                $price = $item->product->selling_price > 0
                    ? $item->product->selling_price
                    : 50000; // fallback raw material

                $subtotal = $price * $item->quantity;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $totalQty += $item->quantity;
                $totalAmount += $subtotal;
            }

            // Update total PO
            $po->update([
                'total_qty' => $totalQty,
                'total_amount' => $totalAmount,
            ]);

            Log::info('PurchaseOrderItemSeeder executed', [
                'po_number' => $po->po_number,
                'items' => $pr->items->count(),
                'total_amount' => $totalAmount,
            ]);
        });
    }
}
