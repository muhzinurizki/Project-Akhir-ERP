<?php

namespace App\Http\Controllers; // Sesuaikan folder jika perlu

use App\Http\Controllers\Controller;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    public function index()
    {
        // Sesuaikan 'requester' dengan 'user' (relasi di model)
        $prs = PurchaseRequest::with(['user'])
            ->latest()
            ->paginate(15);

        return view('purchase-requests.index', compact('prs'));
    }

    public function create()
    {
        return view('purchase-requests.create', [
            'products' => Product::all(), // Pastikan kolom is_active ada di DB jika ingin filter
            'warehouses' => Warehouse::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_date' => 'required|date',
            'note' => 'nullable|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        try {
            DB::beginTransaction();

            // Menggunakan method static dari model yang kita buat tadi
            $pr = PurchaseRequest::create([
                'pr_number' => PurchaseRequest::generatePrNumber(),
                'request_date' => $validated['request_date'],
                'user_id' => Auth::id(),
                'status' => 'PENDING',
                'note' => $validated['note'],
            ]);

            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);

                PurchaseRequestItem::create([
                    'purchase_request_id' => $pr->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['quantity'],
                    // Menyimpan nama satuan saat ini agar histori aman jika satuan produk diubah
                    'unit_name' => $product->unit->name ?? 'Unit',
                ]);
            }

            DB::commit();
            return redirect()->route('purchase-requests.index')
                             ->with('success', "PR {$pr->pr_number} berhasil dibuat.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $pr = PurchaseRequest::with(['items.product.unit', 'user'])->findOrFail($id);
        return view('purchase-requests.show', compact('pr'));
    }

    // Method tambahan untuk aksi Status (Simple implementation)
    public function updateStatus(Request $request, PurchaseRequest $purchaseRequest)
    {
        $request->validate(['status' => 'required|in:APPROVED,REJECTED']);

        $purchaseRequest->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status PR berhasil diperbarui.');
    }
}