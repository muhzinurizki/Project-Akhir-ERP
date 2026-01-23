<?php

namespace App\Http\Controllers\QC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QcInspection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\ProductCategory;
class QcInspectionController extends Controller
{

    public function index(Request $request)
    {
        // 1. Base Query
        $query = Product::with(['category', 'unit'])
            ->whereDoesntHave('qcInspections');

        // 2. Search (Name / SKU)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('sku', 'like', '%' . $request->search . '%');
            });
        }

        // 3. Filter Category
        if ($request->filled('category')) {
            $query->where('product_category_id', $request->category);
        }

        // 4. Filter Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 5. Pagination
        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('qc.inspections.index', [
            'products'   => $products,
            'categories' => ProductCategory::orderBy('name')->get(),
        ]);
    }

    /**
     * Show inspection form
     */
    public function create($productId)
    {
        $product = Product::with(['category', 'unit'])->findOrFail($productId);

        return view('qc.inspections.create', compact('product'));
    }

    /**
     * Store inspection result
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'status'     => ['required', 'in:APPROVED,REJECTED'],
            'note'       => ['nullable', 'string'],
        ]);

        try {
            DB::beginTransaction();

            QcInspection::create([
                'product_id'   => $validated['product_id'],
                'inspector_id' => auth()->id(),
                'status'       => $validated['status'],
                'note'         => $validated['note'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('qc-inspections.index')
                ->with('success', 'QC inspection saved successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage(), $e->getTraceAsString());

            // 🔥 penting buat debugging
            Log::error('QC Inspection Store Failed', [
                'product_id' => $validated['product_id'] ?? null,
                'inspector'  => auth()->id(),
                'error'      => $e->getMessage(),
                'trace'      => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Failed to save QC inspection. Please try again.');
        }
    }
}
