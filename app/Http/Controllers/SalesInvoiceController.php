<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesInvoiceController extends Controller
{
  /**
   * Menampilkan daftar invoice dengan statistik piutang.
   */
  public function index()
  {
    // Eager loading customer untuk menghindari N+1 query
    $invoices = SalesInvoice::with('customer')
      ->latest()
      ->paginate(12);

    // Menghitung statistik piutang secara efisien
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

  /**
   * Form pembuatan invoice baru.
   */
  public function create()
  {
    $customers = Customer::orderBy('name', 'asc')->get();
    return view('sales-invoices.create', compact('customers'));
  }

  /**
   * Menyimpan invoice baru ke database.
   */
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

    // Metadata otomatis
    $validated['created_by'] = Auth::id();
    $validated['received_amount'] = 0;

    // Logika Status Awal: Jika tanggal jatuh tempo sudah lewat saat input
    $validated['status'] = now()->parse($validated['due_date'])->isPast() ? 'overdue' : 'unpaid';

    SalesInvoice::create($validated);

    return redirect()->route('sales-invoices.index')
      ->with('success', "Invoice #{$validated['invoice_number']} berhasil diterbitkan.");
  }

  /**
   * Menampilkan detail invoice beserta riwayat pembayaran.
   */
  public function show(SalesInvoice $salesInvoice)
  {
    // Load relasi customer, creator (user), dan arPayments (riwayat bayar)
    // ArPayments diasumsikan memiliki relasi hasMany di Model SalesInvoice
    $salesInvoice->load(['customer', 'creator', 'arPayments' => function ($query) {
      $query->latest();
    }]);

    return view('sales-invoices.show', compact('salesInvoice'));
  }

  /**
   * Form edit invoice.
   */
  public function edit(SalesInvoice $salesInvoice)
  {
    $customers = Customer::orderBy('name', 'asc')->get();
    return view('sales-invoices.edit', compact('salesInvoice', 'customers'));
  }

  /**
   * Update data invoice dan hitung ulang status.
   */
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

    // Hitung ulang status berdasarkan nominal yang baru diupdate
    $received = $salesInvoice->received_amount;
    $total = $validated['total_amount'];

    if ($received >= $total && $total > 0) {
      $validated['status'] = 'paid';
    } elseif ($received > 0) {
      $validated['status'] = 'partial';
    } else {
      $validated['status'] = now()->parse($validated['due_date'])->isPast() ? 'overdue' : 'unpaid';
    }

    $salesInvoice->update($validated);

    return redirect()->route('sales-invoices.show', $salesInvoice)
      ->with('success', 'Data invoice berhasil diperbarui.');
  }

  /**
   * Menghapus invoice (Hanya jika belum ada pembayaran).
   */
  public function destroy(SalesInvoice $salesInvoice)
  {
    // Proteksi integritas data
    if ($salesInvoice->received_amount > 0) {
      return back()->with('error', 'Critical: Invoice tidak bisa dihapus karena sudah memiliki riwayat pembayaran.');
    }

    $salesInvoice->delete();

    return redirect()->route('sales-invoices.index')
      ->with('success', 'Invoice berhasil dihapus dari sistem.');
  }
}
