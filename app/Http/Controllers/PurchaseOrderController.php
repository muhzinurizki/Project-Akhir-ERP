<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $pos = PurchaseOrder::with(['supplier', 'purchaseRequest'])
            ->latest()
            ->paginate(15);

        return view('purchase-orders.index', compact('pos'));
    }

    public function create()
    {
        return view('purchase-orders.create', [
            'purchaseRequests' => PurchaseRequest::where('status', 'APPROVED')->get(),
            'suppliers' => Supplier::where('is_active', true)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'purchase_request_id' => 'required|exists:purchase_requests,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'po_date' => 'required|date',
            'note' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data) {

            $pr = PurchaseRequest::with('items')->findOrFail($data['purchase_request_id']);

            $po = PurchaseOrder::create([
                'po_number' => $this->generatePoNumber(),
                'po_date' => $data['po_date'],
                'purchase_request_id' => $pr->id,
                'supplier_id' => $data['supplier_id'],
                'warehouse_id' => $pr->warehouse_id,
                'status' => 'DRAFT',
                'created_by' => Auth::id(),
                'note' => $data['note'] ?? null,
            ]);

            foreach ($pr->items as $item) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                ]);
            }
        });

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Purchase Order berhasil dibuat');
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['items.product', 'supplier', 'purchaseRequest']);
        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    public function submit(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->submit();
        return back()->with('success', 'PO disubmit');
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->approve(Auth::id());
        return back()->with('success', 'PO di-approve');
    }

    private function generatePoNumber(): string
    {
        $date = now()->format('Ymd');
        $count = PurchaseOrder::whereDate('created_at', today())->count() + 1;
        return 'PO-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
