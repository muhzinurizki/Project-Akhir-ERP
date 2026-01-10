<?php

namespace App\Http\Controllers;

use App\Models\ArPayment;
use App\Models\SalesInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArPaymentController extends Controller
{
  public function store(Request $request)
  {
    $request->validate([
      'sales_invoice_id' => 'required|exists:sales_invoices,id',
      'payment_date'     => 'required|date',
      'amount'           => 'required|numeric|min:1',
      'payment_method'   => 'required|string',
      'reference_number' => 'nullable|string',
    ]);

    try {
      DB::beginTransaction();

      $invoice = SalesInvoice::findOrFail($request->sales_invoice_id);

      // 1. Simpan data pembayaran
      ArPayment::create([
        'sales_invoice_id' => $request->sales_invoice_id,
        'payment_date'     => $request->payment_date,
        'amount'           => $request->amount,
        'payment_method'   => $request->payment_method,
        'reference_number' => $request->reference_number,
        'note'             => $request->note,
        'created_by'       => Auth::id(),
      ]);

      // 2. Update received_amount di Sales Invoice
      $newReceivedAmount = $invoice->received_amount + $request->amount;

      // 3. Tentukan status baru
      $status = 'partial';
      if ($newReceivedAmount >= $invoice->total_amount) {
        $status = 'paid';
      }

      $invoice->update([
        'received_amount' => $newReceivedAmount,
        'status'          => $status
      ]);

      DB::commit();
      return back()->with('success', 'Pembayaran berhasil dicatat. Status Invoice diperbarui.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function destroy(ArPayment $arPayment)
  {
    try {
      DB::beginTransaction();

      $invoice = $arPayment->salesInvoice;

      // Kurangi received_amount sebelum data dihapus
      $newAmount = $invoice->received_amount - $arPayment->amount;
      $status = ($newAmount <= 0) ? 'unpaid' : 'partial';

      $invoice->update([
        'received_amount' => $newAmount,
        'status'          => $status
      ]);

      $arPayment->delete();

      DB::commit();
      return back()->with('success', 'Riwayat pembayaran berhasil dihapus.');
    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Gagal menghapus pembayaran.');
    }
  }

  public function show(SalesInvoice $salesInvoice)
  {
    $salesInvoice->load(['customer', 'creator', 'arPayments.creator']);
    return view('sales_invoices.show', compact('salesInvoice'));
  }
}
