<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Product;
use App\Models\Supplier; // Pastikan ini sesuai nama model supplier Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
  public function index()
  {
    $pos = PurchaseOrder::with(['supplier', 'creator'])->latest()->get();
    return view('purchase-orders.index', compact('pos'));
  }

  public function create()
  {
    // 1. Ambil data Supplier
    $suppliers = Supplier::orderBy('name')->get();

    // 2. Ambil data Produk
    $products = Product::orderBy('name')->get();

    // 3. Ambil PR yang statusnya sudah APPROVED (untuk referensi)
    $approvedPRs = PurchaseRequest::where('status', 'APPROVED')->get();

    // Kirim semua variabel ke view
    return view('purchase-orders.create', compact('suppliers', 'products', 'approvedPRs'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'supplier_id' => 'required|exists:suppliers,id',
      'items' => 'required|array|min:1',
      'items.*.product_id' => 'required|exists:products,id',
      'items.*.qty' => 'required|numeric|min:1',
      'items.*.price' => 'required|numeric|min:0',
    ]);

    try {
      return DB::transaction(function () use ($request) {
        $subtotal = 0;

        // Hitung subtotal di backend (lebih aman)
        foreach ($request->items as $item) {
          $subtotal += ($item['qty'] * $item['price']);
        }

        $tax = $subtotal * 0.11; // PPN 11%
        $total = $subtotal + $tax;

        // 1. Simpan Header PO
        $po = PurchaseOrder::create([
          'supplier_id' => $request->supplier_id,
          'purchase_request_id' => $request->purchase_request_id,
          'po_date' => now(),
          'subtotal' => $subtotal,
          'tax_percent' => 11,
          'tax_amount' => $tax,
          'grand_total' => $total,
          'status' => 'SENT',
        ]);

        // 2. Simpan Item PO
        foreach ($request->items as $item) {
          $po->items()->create([
            'product_id' => $item['product_id'],
            'qty' => $item['qty'],
            'unit_price' => $item['price'],
            'total_price' => $item['qty'] * $item['price']
          ]);
        }

        return redirect()->route('purchase-orders.index')->with('success', 'PO Berhasil Diterbitkan!');
      });
    } catch (\Exception $e) {
      return back()->with('error', 'Gagal membuat PO: ' . $e->getMessage())->withInput();
    }
  }

  public function show($id)
  {
    $po = PurchaseOrder::with(['items.product', 'supplier', 'pr'])->findOrFail($id);
    return view('purchase-orders.show', compact('po'));
  }
}
