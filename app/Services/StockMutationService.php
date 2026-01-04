<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockMutation;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMutationService
{
    public function mutate(
        string $itemType,
        int $itemId,
        int $warehouseId,
        float $qty,
        string $mutationType,     // IN | OUT | ADJUST
        string $referenceType,
        int $referenceId,
        ?int $userId = null
    ): StockMutation {
        return DB::transaction(function () use (
            $itemType,
            $itemId,
            $warehouseId,
            $qty,
            $mutationType,
            $referenceType,
            $referenceId,
            $userId
        ) {
            /** @var Stock $stock */
            $stock = Stock::where([
                'warehouse_id' => $warehouseId,
                'item_type'    => $itemType,
                'item_id'      => $itemId,
            ])->lockForUpdate()->first();

            if (! $stock) {
                $stock = Stock::create([
                    'warehouse_id' => $warehouseId,
                    'item_type'    => $itemType,
                    'item_id'      => $itemId,
                    'qty'          => 0,
                ]);
            }

            $currentQty = (float) $stock->qty;

            $newQty = match ($mutationType) {
                'IN'     => $currentQty + $qty,
                'OUT'    => $currentQty - $qty,
                'ADJUST' => $currentQty + $qty, // qty bisa + / -
                default  => throw ValidationException::withMessages([
                    'mutation_type' => 'Invalid mutation type',
                ]),
            };

            if ($newQty < 0) {
                throw ValidationException::withMessages([
                    'qty' => 'Stock tidak mencukupi',
                ]);
            }

            $stock->update(['qty' => $newQty]);

            return StockMutation::create([
                'item_type'       => $itemType,
                'item_id'         => $itemId,
                'warehouse_id'    => $warehouseId,
                'mutation_type'   => $mutationType,
                'reference_type'  => $referenceType,
                'reference_id'    => $referenceId,
                'qty'             => $qty,
                'balance_after'   => $newQty,
                'created_by'      => $userId,
            ]);
        });
    }
}
