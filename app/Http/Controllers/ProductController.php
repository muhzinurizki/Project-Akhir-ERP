<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'unit']);

        // Filter Pencarian
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        // Filter Tipe
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Urutkan berdasarkan stok terendah jika diminta (opsional untuk monitoring)
        $products = $query->latest()->paginate(10)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => ProductCategory::orderBy('name')->get()
        ]);
    }

    public function create()
    {
        return view('products.create', [
            'categories' => ProductCategory::orderBy('name')->get(),
            'units'      => Unit::orderBy('code')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|in:raw_material,semi_finished,finished',
            'is_active' => 'nullable|boolean',
            'stock' => 'nullable|numeric|min:0', // Tambahkan validasi stok awal
            'specification' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');
        // Set stok ke 0 jika tidak diisi
        $validated['stock'] = $request->stock ?? 0;

        try {
            DB::beginTransaction();
            Product::create($validated);
            DB::commit();

            return redirect()->route('products.index')
                ->with('success', "Produk {$validated['name']} berhasil disimpan.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Product Store Error: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product'    => $product,
            'categories' => ProductCategory::orderBy('name')->get(),
            'units'      => Unit::orderBy('code')->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'unit_id' => 'required|exists:units,id',
            'type' => 'required|in:raw_material,semi_finished,finished',
            'is_active' => 'nullable|boolean',
            'stock' => 'required|numeric|min:0', // Pastikan stok tetap tervalidasi saat update
            'specification' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        try {
            DB::beginTransaction();
            $product->update($validated);
            DB::commit();

            return redirect()->route('products.index')
                ->with('success', "Produk {$product->name} berhasil diperbarui.");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Product Update Error: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui produk.');
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Produk tidak bisa dihapus karena sudah memiliki histori transaksi.');
        }
    }
}