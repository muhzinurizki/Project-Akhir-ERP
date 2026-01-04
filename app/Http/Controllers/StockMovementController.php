<?php

namespace App\Http\Controllers;

use App\Models\StockMovement;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    /**
     * Menampilkan riwayat mutasi stok dengan filter.
     */
    public function index(Request $request)
    {
        $movements = StockMovement::with(['product', 'warehouse', 'user'])
            ->when($request->product_id, function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->latest()
            ->paginate(20);

        $products = Product::orderBy('name')->get();

        return view('stock-movements.index', compact('movements', 'products'));
    }

    /**
     * Form untuk Manual Adjustment (Penyesuaian Stok Manual).
     */
    public function create()
    {
        $products = Product::all();
        $warehouses = Warehouse::all();
        return view('stock-movements.create', compact('products', 'warehouses'));
    }

    /**
     * Menyimpan penyesuaian stok manual.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'type'         => 'required|in:in,out',
            'quantity'     => 'required|numeric|min:1',
            'reference'    => 'required|string|max:100', // Contoh: "Stock Opname Jan"
            'note'         => 'nullable|string'
        ]);

        // Simpan mutasi
        StockMovement::create([
            'product_id'   => $validated['product_id'],
            'warehouse_id' => $validated['warehouse_id'],
            'type'         => $validated['type'],
            'quantity'     => $validated['quantity'],
            'reference'    => $validated['reference'],
            'user_id'      => auth()->id(),
            'note'         => $validated['note'],
        ]);

        return redirect()->route('stock-movements.index')
            ->with('success', 'Mutasi stok manual berhasil dicatat.');
    }

    /**
     * Detail Mutasi.
     */
    public function show(StockMovement $stockMovement)
    {
        return view('stock-movements.show', compact('stockMovement'));
    }

    // Update dan Destroy biasanya ditiadakan dalam audit log stok
    // agar data mutasi tidak bisa dimanipulasi secara ilegal.
}