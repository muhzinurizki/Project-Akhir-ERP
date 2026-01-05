<?php

namespace App\Http\Controllers;

use App\Models\PurchaseInvoice;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <--- Pastikan baris ini ada

class PurchaseInvoiceController extends Controller
{
    public function index()
    {
        // Statistik untuk Header
        $stats = [
            'total_ap' => PurchaseInvoice::where('status', '!=', 'paid')
                ->sum(DB::raw('total_amount - paid_amount')), // Sekarang DB sudah dikenali
            'overdue_count' => PurchaseInvoice::where('status', 'overdue')->orWhere(function ($q) {
                $q->where('status', '!=', 'paid')->where('due_date', '<', now());
            })->count(),
            'upcoming_payment' => PurchaseInvoice::whereBetween('due_date', [now(), now()->addDays(7)])
                ->where('status', '!=', 'paid')->sum('total_amount'),
        ];

        $invoices = PurchaseInvoice::with('supplier')
            ->orderBy('due_date', 'asc')
            ->paginate(15);

        return view('purchase_invoices.index', compact('invoices', 'stats'));
    }

    public function create()
    {
        $suppliers = Supplier::where('is_active', true)->get();

        // Pastikan file resources/views/purchase_invoices/create.blade.php sudah ada
        return view('purchase_invoices.create', compact('suppliers'));
    }

    public function edit(PurchaseInvoice $purchaseInvoice)
    {
        $suppliers = Supplier::where('is_active', true)->get();

        return view('purchase_invoices.edit', compact('purchaseInvoice', 'suppliers'));
    }

    public function update(Request $request, PurchaseInvoice $purchaseInvoice)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|string|unique:purchase_invoices,invoice_number,'.$purchaseInvoice->id,
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'total_amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        // Logika Otomatis: Update Status berdasarkan nominal yang sudah dibayar
        // Jika total diubah menjadi lebih kecil dari yang sudah dibayar
        if ($validated['total_amount'] <= $purchaseInvoice->paid_amount) {
            $validated['status'] = 'paid';
        } elseif ($purchaseInvoice->paid_amount > 0) {
            $validated['status'] = 'partial';
        } else {
            $validated['status'] = 'unpaid';
        }

        // Cek ulang jika overdue
        if ($validated['status'] !== 'paid' && \Carbon\Carbon::parse($validated['due_date'])->isPast()) {
            $validated['status'] = 'overdue';
        }

        $purchaseInvoice->update($validated);

        return redirect()->route('purchase-invoices.index')
            ->with('success', 'Data invoice #'.$purchaseInvoice->invoice_number.' berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'invoice_number' => 'required|string|unique:purchase_invoices,invoice_number',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'total_amount' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        // Tambahkan user ID yang menginput
        $validated['created_by'] = auth()->id();
        $validated['paid_amount'] = 0;
        $validated['status'] = 'unpaid';

        PurchaseInvoice::create($validated);

        return redirect()->route('purchase-invoices.index')
            ->with('success', 'Invoice berhasil dicatat ke dalam sistem.');
    }

    public function destroy(PurchaseInvoice $purchaseInvoice)
    {
        // Cek jika sudah ada pembayaran, opsional: larang hapus jika sudah ada cicilan
        if ($purchaseInvoice->paid_amount > 0) {
            return back()->with('error', 'Tidak dapat menghapus invoice yang sudah memiliki riwayat pembayaran.');
        }

        $purchaseInvoice->delete();

        return redirect()->route('purchase-invoices.index')
            ->with('success', 'Invoice #'.$purchaseInvoice->invoice_number.' telah dihapus dari sistem.');
    }
}
