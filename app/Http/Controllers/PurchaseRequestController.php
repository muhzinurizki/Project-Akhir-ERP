<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestItem;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseRequestController extends Controller
{
    /* =======================
     |  LIST PR
     ======================= */
    public function index()
    {
        $prs = PurchaseRequest::with(['warehouse', 'requester'])
            ->latest()
            ->paginate(15);

        return view('purchase-requests.index', compact('prs'));
    }

    /* =======================
     |  CREATE PR FORM
     ======================= */
    public function create()
    {
        return view('purchase-requests.create', [
            'products' => Product::where('is_active', true)->get(),
            'warehouses' => Warehouse::where('is_active', true)->get(),
        ]);
    }

    /* =======================
     |  STORE PR (HEADER + ITEMS)
     ======================= */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'request_date' => 'required|date',
            'warehouse_id' => 'required|exists:warehouses,id',
            'note' => 'nullable|string',

            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            $pr = PurchaseRequest::create([
                'pr_number' => $this->generatePrNumber(),
                'request_date' => $validated['request_date'],
                'warehouse_id' => $validated['warehouse_id'],
                'status' => 'DRAFT',
                'requested_by' => Auth::id(),
                'note' => $validated['note'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {
                PurchaseRequestItem::create([
                    'purchase_request_id' => $pr->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'note' => $item['note'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('purchase-requests.index')
            ->with('success', 'Purchase Request berhasil dibuat');
    }

    /* =======================
     |  SHOW DETAIL PR
     ======================= */
    public function show(PurchaseRequest $purchaseRequest)
    {
        $purchaseRequest->load(['items.product', 'warehouse', 'requester', 'approver']);

        return view('purchase-requests.show', compact('purchaseRequest'));
    }

    /* =======================
     |  SUBMIT PR
     ======================= */
    public function submit(PurchaseRequest $purchaseRequest)
    {
        if (!$purchaseRequest->isEditable()) {
            abort(403, 'PR tidak dapat disubmit');
        }

        $purchaseRequest->submit();

        return back()->with('success', 'PR berhasil disubmit');
    }

    /* =======================
     |  APPROVE PR
     ======================= */
    public function approve(PurchaseRequest $purchaseRequest)
    {
        if (!$purchaseRequest->canBeApproved()) {
            abort(403, 'PR tidak dapat di-approve');
        }

        $purchaseRequest->approve(Auth::id());

        return back()->with('success', 'PR berhasil di-approve');
    }

    /* =======================
     |  REJECT PR
     ======================= */
    public function reject(PurchaseRequest $purchaseRequest)
    {
        if (!$purchaseRequest->canBeApproved()) {
            abort(403, 'PR tidak dapat di-reject');
        }

        $purchaseRequest->reject(Auth::id());

        return back()->with('success', 'PR berhasil di-reject');
    }

    /* =======================
     |  HELPER: PR NUMBER
     ======================= */
    private function generatePrNumber(): string
    {
        $date = now()->format('Ymd');
        $countToday = PurchaseRequest::whereDate('created_at', today())->count() + 1;

        return 'PR-' . $date . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);
    }
}
