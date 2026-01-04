<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $pos = PurchaseOrder::with(['supplier', 'user', 'purchaseRequest'])
            ->latest()
            ->paginate(15);

        return view('purchase-orders.index', compact('pos'));
    }

    public function create(Request $request)
    {
        // Pastikan ada ID PR yang dikirim dari halaman list APPROVED PR
        $request->validate([
            'pr_id' => 'required|exists:purchase_requests,id',
        ]);

        // Cari PR yang statusnya APPROVED dan belum pernah dibuatkan PO
        $pr = PurchaseRequest::with('items.product.unit')
            ->where('status', 'APPROVED')
            ->whereDoesntHave('purchaseOrder')
            ->findOrFail($request->pr_id);

        $suppliers = Supplier::where('is_active', true)->get();
        $po_number = PurchaseOrder::generatePoNumber();

        return view('purchase-orders.create', compact('pr', 'suppliers', 'po_number'));
    }

    public function store(Request $request)
    {
        // Tambahkan ini di baris paling atas untuk melihat apa yang dikirim dari form
        // dd($request->all());

        try {
            DB::beginTransaction();

            // 1. Validasi manual untuk memastikan user login
            if (! auth()->check()) {
                throw new \Exception('Anda harus login untuk membuat PO.');
            }

            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += ($item['qty'] * $item['unit_price']);
            }

            $taxAmount = ($subtotal * $request->tax_percent) / 100;
            $grandTotal = $subtotal + $taxAmount;

            // 2. Gunakan forceFill untuk memastikan data dipaksa masuk
            $po = new \App\Models\PurchaseOrder;
            $po->po_number = \App\Models\PurchaseOrder::generatePoNumber();
            $po->purchase_request_id = $request->purchase_request_id;
            $po->supplier_id = $request->supplier_id;
            $po->user_id = auth()->id();
            $po->po_date = $request->po_date;
            $po->subtotal = $subtotal;
            $po->tax_percent = $request->tax_percent;
            $po->tax_amount = $taxAmount;
            $po->grand_total = $grandTotal;
            $po->status = 'SENT';
            $po->note = $request->note;
            $po->save(); // Simpan Header

            // 3. Simpan Detail
            foreach ($request->items as $item) {
                \App\Models\PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'unit_price' => $item['unit_price'],
                    'total_price' => $item['qty'] * $item['unit_price'],
                ]);
            }

            // 4. Update Status PR
            \App\Models\PurchaseRequest::where('id', $request->purchase_request_id)
                ->update(['status' => 'COMPLETED']);

            DB::commit();

            return redirect()->route('purchase-orders.index')->with('success', 'PO Berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            // INI AKAN MENUNJUKKAN ERROR SEBENARNYA
            dd('ERROR DATABASE: '.$e->getMessage());
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load(['supplier', 'items.product.unit', 'purchaseRequest', 'user']);

        return view('purchase-orders.show', compact('purchaseOrder'));
    }
}
