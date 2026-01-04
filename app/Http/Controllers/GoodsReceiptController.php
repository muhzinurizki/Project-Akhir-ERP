<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\StockMutation;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoodsReceiptController extends Controller
{
  /**
   * Tampilkan Daftar Penerimaan Barang
   */
  public function index()
  {
    // Eager Loading relasi agar tidak error di Blade
    $receipts = GoodsReceipt::with(['purchaseOrder', 'warehouse', 'receiver'])
      ->latest()
      ->paginate(15);

    return view('goods-receipts.index', compact('receipts'));
  }

  /**
   * Form Input Penerimaan
   */
  public function create()
  {
    $purchaseOrders = PurchaseOrder::with(['items.product', 'warehouse', 'supplier'])
      ->where('status', 'APPROVED')
      ->whereHas('items', function ($q) {
        $q->whereColumn('received_quantity', '<', 'quantity');
      })
      ->get();

    return view('goods-receipts.create', compact('purchaseOrders'));
  }

  /**
   * Proses Simpan Penerimaan & Update Stok
   */
  public function store(Request $request)
  {
    $data = $request->validate([
      'purchase_order_id' => 'required|exists:purchase_orders,id',
      'gr_date' => 'required|date',
      'items' => 'required|array|min:1',
      'items.*.purchase_order_item_id' => 'required|exists:purchase_order_items,id',
      'items.*.quantity' => 'required|numeric|min:0.0001',
    ]);

    try {
      return DB::transaction(function () use ($data) {
        $po = PurchaseOrder::findOrFail($data['purchase_order_id']);

        // Buat GR (gr_number otomatis dibuat oleh Model)
        $gr = GoodsReceipt::create([
          'gr_date' => $data['gr_date'],
          'purchase_order_id' => $po->id,
          'warehouse_id' => $po->warehouse_id,
          'received_by' => auth()->id(),
          'note' => $data['note'] ?? null,
        ]);

        foreach ($data['items'] as $row) {
          $poItem = PurchaseOrderItem::findOrFail($row['purchase_order_item_id']);

          // Simpan Item
          $gr->items()->create([
            'purchase_order_item_id' => $poItem->id,
            'product_id' => $poItem->product_id,
            'quantity' => $row['quantity'],
          ]);

          // Update PO progress
          $poItem->increment('received_quantity', $row['quantity']);

          // Hitung stok sebelum transaksi berdasarkan mutasi sebelumnya
          $previousMutation = StockMutation::where('item_type', 'product')
            ->where('item_id', $poItem->product_id)
            ->where('warehouse_id', $gr->warehouse_id)
            ->latest('created_at')
            ->first();

          $balanceBeforeValue = $previousMutation ? $previousMutation->balance_after : 0;

          // Hitung stok setelah transaksi
          $balanceAfterValue = $balanceBeforeValue + $row['quantity'];

          // Catat Mutasi
          $gr->stockMutations()->create([
            'item_type' => 'product',
            'item_id' => $poItem->product_id,
            'warehouse_id' => $gr->warehouse_id,
            'mutation_type' => 'IN',
            'qty' => $row['quantity'],
            'balance_before' => $balanceBeforeValue,
            'balance_after' => $balanceAfterValue,
            'reference_type' => \App\Models\GoodsReceipt::class,
            'reference_id' => $gr->id,
            'created_by' => auth()->id(),
          ]);
        }

        // Update status PO jika sudah komplit
        $gr->updateParentPoStatus();

        return redirect()->route('goods-receipts.index')->with('success', 'Data tersimpan.');
      });
    } catch (\Exception $e) {
      return back()->with('error', $e->getMessage());
    }
  }

  /**
   * Tampilkan Detail Dokumen
   */
  public function show(GoodsReceipt $goodsReceipt)
  {
    $goodsReceipt->load(['items.product', 'purchaseOrder', 'warehouse', 'receiver']);
    return view('goods-receipts.show', compact('goodsReceipt'));
  }

}