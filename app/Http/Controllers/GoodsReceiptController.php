<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\Product;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GoodsReceiptController extends Controller
{
    public function index()
    {
        $grs = GoodsReceipt::with(['purchaseOrder', 'user'])
            ->latest()
            ->paginate(15);

        return view('goods-receipts.index', compact('grs'));
    }

    public function create(Request $request)
    {
        $po_id = $request->query('po_id');

        if (!$po_id) {
            return redirect()->route('purchase-orders.index')
                ->with('error', 'Silahkan pilih PO terlebih dahulu.');
        }

        $po = PurchaseOrder::with(['items.product.unit', 'supplier'])
            ->findOrFail($po_id);

        $gr_number = GoodsReceipt::generateGrNumber();

        return view('goods-receipts.create', compact('po', 'gr_number'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required',
            'received_date' => 'required|date',
            'surat_jalan_number' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.qty_received' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. Buat Header GR
            $gr = GoodsReceipt::create([
                'gr_number' => GoodsReceipt::generateGrNumber(),
                'purchase_order_id' => $request->purchase_order_id,
                'user_id' => auth()->id(),
                'received_date' => $request->received_date,
                'surat_jalan_number' => $request->surat_jalan_number,
                'note' => $request->note,
            ]);

            // 2. Simpan Detail & Update Stok
            foreach ($request->items as $item) {
                $gr->items()->create([
                    'product_id' => $item['product_id'],
                    'qty_ordered' => $item['qty_ordered'],
                    'qty_received' => $item['qty_received'],
                ]);

                // Update stok produk
                $product = Product::findOrFail($item['product_id']);
                $product->increment('stock', $item['qty_received']);
            }

            // 3. Update Status PO
            PurchaseOrder::where('id', $request->purchase_order_id)->update([
                'status' => 'RECEIVED',
            ]);

            DB::commit();
            return redirect()->route('goods-receipts.index')->with('success', 'Penerimaan barang berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal simpan GR: ' . $e->getMessage());
            
            // Mengirim pesan error asli ke view agar mudah di-debug
            return back()->with('error', 'Database Error: ' . $e->getMessage())->withInput();
        }
    }

    public function show(GoodsReceipt $goodsReceipt)
    {
        $goodsReceipt->load(['items.product', 'purchaseOrder', 'user']);
        return view('goods-receipts.show', compact('goodsReceipt'));
    }
}