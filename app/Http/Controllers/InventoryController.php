<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockMovement;
use App\Models\ProductWarehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
  // Menampilkan daftar saldo stok saat ini
  public function index()
  {
    $stocks = ProductWarehouse::with(['product', 'warehouse'])->get();
    return view('inventory.index', compact('stocks'));
  }

  // Form Barang Masuk
  public function createIn()
  {
    $products = Product::all();
    $warehouses = Warehouse::all();
    return view('inventory.create-in', compact('products', 'warehouses'));
  }

  // Simpan Barang Masuk
  public function storeIn(Request $request)
  {
    $request->validate([
      'product_id' => 'required|exists:products,id',
      'warehouse_id' => 'required|exists:warehouses,id',
      'quantity' => 'required|numeric|min:0.001',
      'reference' => 'required|string',
    ]);

    StockMovement::create([
      'product_id' => $request->product_id,
      'warehouse_id' => $request->warehouse_id,
      'quantity' => $request->quantity,
      'type' => 'IN',
      'reference' => $request->reference,
      'created_by' => auth()->id(),
    ]);

    return redirect()->route('inventory.index')->with('success', 'Stok berhasil masuk.');
  }

  // Form Barang Keluar
  public function createOut()
  {
    $products = Product::all();
    $warehouses = Warehouse::all();
    return view('inventory.create-out', compact('products', 'warehouses'));
  }

  // Simpan Barang Keluar
  public function storeOut(Request $request)
  {
    $request->validate([
      'product_id' => 'required|exists:products,id',
      'warehouse_id' => 'required|exists:warehouses,id',
      'quantity' => 'required|numeric|min:0.001',
      'reference' => 'required|string',
    ]);

    // Proteksi: Cek stok di tabel saldo
    $currentStock = StockMovement::getCurrentStock($request->product_id, $request->warehouse_id);

    if ($currentStock < $request->quantity) {
      return back()->with('error', 'Stok tidak mencukupi! Sisa stok: ' . $currentStock);
    }

    StockMovement::create([
      'product_id' => $request->product_id,
      'warehouse_id' => $request->warehouse_id,
      'quantity' => $request->quantity,
      'type' => 'OUT',
      'reference' => $request->reference,
      'created_by' => auth()->id(),
    ]);

    return redirect()->route('inventory.index')->with('success', 'Stok berhasil dikeluarkan.');
  }

  // Tambahkan di dalam class InventoryController

  public function movements()
  {
    // 1. Ambil data log mutasi dengan pagination
    $movements = \App\Models\StockMutation::with(['item', 'warehouse', 'creator'])
      ->latest()
      ->paginate(20);

    // 2. Hitung Total Masuk & Keluar (Bulan Ini)
    // Menggunakan sum('qty') berdasarkan range tanggal bulan sekarang
    $totalIn = \App\Models\StockMutation::where('mutation_type', 'IN')
      ->whereMonth('created_at', now()->month)
      ->whereYear('created_at', now()->year)
      ->sum('qty');

    $totalOut = \App\Models\StockMutation::where('mutation_type', 'OUT')
      ->whereMonth('created_at', now()->month)
      ->whereYear('created_at', now()->year)
      ->sum('qty');

    // 3. Kirim semua variabel ke view
    return view('inventory.movements', compact('movements', 'totalIn', 'totalOut'));
  }
}