<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesInvoiceController extends Controller
{
    public function index()
    {
        $invoices = SalesInvoice::with('customer')->latest()->paginate(10);
        
        // Menghitung statistik piutang
        $stats = [
            'total_ar' => SalesInvoice::where('status', '!=', 'paid')
                ->sum(DB::raw('total_amount - received_amount')),
            'overdue_count' => SalesInvoice::where('status', '!=', 'paid')
                ->where('due_date', '<', now())
                ->count(),
            'upcoming_collection' => SalesInvoice::where('status', '!=', 'paid')
                ->whereBetween('due_date', [now(), now()->addDays(7)])
                ->sum(DB::raw('total_amount - received_amount')),
        ];

        return view('sales-invoices.index', compact('invoices', 'stats'));
    }

    public function create()
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('sales-invoices.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:sales_invoices,invoice_number',
            'invoice_date'   => 'required|date',
            'due_date'       => 'required|date|after_or_equal:invoice_date',
            'total_amount'   => 'required|numeric|min:0',
            'note'           => 'nullable|string',
        ]);

        // Tambahkan metadata otomatis
        $validated['created_by'] = Auth::id();
        $validated['received_amount'] = 0;
        
        // Logika Status Awal
        $status = 'unpaid';
        if (now()->parse($validated['due_date'])->isPast()) {
            $status = 'overdue';
        }
        $validated['status'] = $status;

        SalesInvoice::create($validated);

        return redirect()->route('sales-invoices.index')
            ->with('success', 'Sales Invoice #' . $validated['invoice_number'] . ' berhasil diterbitkan.');
    }

    public function edit(SalesInvoice $salesInvoice)
    {
        $customers = Customer::orderBy('name', 'asc')->get();
        return view('sales_invoices.edit', compact('salesInvoice', 'customers'));
    }

    public function update(Request $request, SalesInvoice $salesInvoice)
    {
        $validated = $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:sales_invoices,invoice_number,' . $salesInvoice->id,
            'invoice_date'   => 'required|date',
            'due_date'       => 'required|date|after_or_equal:invoice_date',
            'total_amount'   => 'required|numeric|min:0',
            'note'           => 'nullable|string',
        ]);

        // Update Status Otomatis berdasarkan nominal
        if ($salesInvoice->received_amount >= $validated['total_amount']) {
            $validated['status'] = 'paid';
        } elseif ($salesInvoice->received_amount > 0) {
            $validated['status'] = 'partial';
        } else {
            // Cek jika overdue
            $validated['status'] = now()->parse($validated['due_date'])->isPast() ? 'overdue' : 'unpaid';
        }

        $salesInvoice->update($validated);

        return redirect()->route('sales-invoices.index')
            ->with('success', 'Invoice berhasil diperbarui.');
    }

    public function show(SalesInvoice $salesInvoice)
    {
        $salesInvoice->load(['customer', 'creator']);
        return view('sales_invoices.show', compact('salesInvoice'));
    }

    public function destroy(SalesInvoice $salesInvoice)
    {
        // Proteksi: Invoice yang sudah ada pembayaran tidak boleh dihapus sembarangan
        if ($salesInvoice->received_amount > 0) {
            return back()->with('error', 'Tidak dapat menghapus invoice yang sudah memiliki riwayat pembayaran.');
        }

        $salesInvoice->delete();

        return redirect()->route('sales-invoices.index')
            ->with('success', 'Invoice berhasil dihapus.');
    }
}