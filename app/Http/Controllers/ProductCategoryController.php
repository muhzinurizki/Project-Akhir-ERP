<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori dengan jumlah produk terkait.
     */
    public function index()
    {
        $categories = ProductCategory::withCount('products')
            ->orderBy('name', 'asc')
            ->get();

        return view('product-categories.index', compact('categories'));
    }

    /**
     * Menampilkan form tambah kategori.
     */
    public function create()
    {
        return view('product-categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:product_categories,code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            ProductCategory::create($validated);
            return redirect()->route('product-categories.index')
                ->with('success', 'Kategori ' . $validated['name'] . ' berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan kategori: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    /**
     * Menampilkan form edit kategori.
     */
    public function edit(ProductCategory $productCategory)
    {
        return view('product-categories.edit', compact('productCategory'));
    }

    /**
     * Memperbarui data kategori.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:product_categories,code,' . $productCategory->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $productCategory->update($validated);
            return redirect()->route('product-categories.index')
                ->with('success', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal update kategori: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui data.');
        }
    }

    /**
     * Menghapus kategori dengan validasi relasi produk.
     */
    public function destroy(ProductCategory $productCategory)
    {
        // Proteksi: Jangan hapus jika kategori masih digunakan oleh produk
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('product-categories.index')
                ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki produk terkait.');
        }

        try {
            $productCategory->delete();
            return redirect()->route('product-categories.index')
                ->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Gagal hapus kategori: ' . $e->getMessage());
            return redirect()->route('product-categories.index')
                ->with('error', 'Gagal menghapus kategori.');
        }
    }
}