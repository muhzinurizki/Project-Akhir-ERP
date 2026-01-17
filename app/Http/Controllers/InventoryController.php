<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockLedger;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Menampilkan daftar saldo stok saat ini.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'unit']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(15);

        // Statistik sederhana untuk header
        $stats = [
            'total_skus' => Product::count(),
            'low_stock_count' => Product::all()->filter(fn($p) => $p->stock_total <= $p->min_stock_level)->count(),
            'total_movements_today' => StockLedger::whereDate('created_at', today())->count(),
        ];

        return view('inventory.index', compact('products', 'stats'));
    }

    /**
     * Form input mutasi stok.
     */
    public function create()
    {
        return view('inventory.create', [
            'products' => Product::active()->orderBy('name')->get(),
            'warehouses' => Warehouse::orderBy('name')->get(),
            'types' => ['IN' => 'Barang Masuk (IN)', 'OUT' => 'Barang Keluar (OUT)']
        ]);
    }

    /**
     * Menyimpan transaksi ke Stock Ledger.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity'     => 'required|integer|min:1',
            'type'         => 'required|in:IN,OUT',
            'reference'    => 'nullable|string|max:100',
            'note'         => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // 1. Ambil saldo terakhir produk tersebut
            $lastBalance = StockLedger::where('product_id', $validated['product_id'])
                ->orderBy('id', 'desc')
                ->value('balance_after') ?? 0;

            // 2. Tentukan delta quantity (Positif jika IN, Negatif jika OUT)
            $qtyDelta = ($validated['type'] === 'OUT') ? -$validated['quantity'] : $validated['quantity'];

            // 3. Simpan ke Ledger
            StockLedger::create([
                'product_id'    => $validated['product_id'],
                'warehouse_id'  => $validated['warehouse_id'],
                'user_id'       => auth()->id(), // Mencatat user yang input
                'quantity'      => $qtyDelta,
                'balance_after' => $lastBalance + $qtyDelta,
                'type'          => $validated['type'],
                'reference'     => $validated['reference'],
                'note'          => $validated['note'],
            ]);

            DB::commit();
            return redirect()->route('inventory.index')->with('success', 'Transaksi stok berhasil dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan histori kartu stok produk.
     */
    public function detail($id)
    {
        $product = Product::with(['category', 'unit'])->findOrFail($id);
        
        $movements = StockLedger::with(['warehouse', 'user'])
            ->where('product_id', $id)
            ->latest('id')
            ->paginate(20);

        return view('inventory.detail', compact('product', 'movements'));
    }
}