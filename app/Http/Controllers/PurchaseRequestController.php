<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseRequestController extends Controller
{
  public function index()
  {
    // Ambil data PR untuk tabel
    $prs = PurchaseRequest::with('user')->latest()->paginate(10);

    // Ambil data Product untuk jaga-jaga jika View Index memanggilnya (misal di Modal)
    $products = Product::orderBy('name')->get();

    return view('purchase-requests.index', compact('prs', 'products'));
  }

  public function create()
  {
    $products = Product::orderBy('name')->get();
    return view('purchase-requests.create', compact('products'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'request_date' => 'required|date',
      'items' => 'required|array|min:1',
      'items.*.product_id' => 'required|exists:products,id',
      'items.*.qty' => 'required|numeric|min:1',
    ]);

    try {
      return DB::transaction(function () use ($request) {
        $pr = PurchaseRequest::create([
          'request_date' => $request->request_date,
          'note' => $request->note,
          'status' => 'PENDING',
        ]);

        foreach ($request->items as $item) {
          $product = Product::findOrFail($item['product_id']);
          $pr->items()->create([
            'product_id' => $item['product_id'],
            'qty' => $item['qty'],
            'unit_name' => $product->unit_name ?? 'PCS',
          ]);
        }

        return redirect()->route('purchase-requests.index')->with('success', 'PR Created Successfully');
      });
    } catch (\Exception $e) {
      return back()->with('error', 'Gagal: ' . $e->getMessage())->withInput();
    }
  }

  public function show($id)
  {
    $pr = PurchaseRequest::with(['items.product', 'user', 'approver'])->findOrFail($id);
    return view('purchase-requests.show', compact('pr'));
  }

  public function updateStatus(Request $request, $id)
  {
    $request->validate([
      'status' => 'required|in:APPROVED,REJECTED',
      'reason' => 'required_if:status,REJECTED|nullable|string|max:255'
    ]);

    $pr = PurchaseRequest::findOrFail($id);

    try {
      DB::transaction(function () use ($request, $pr) {
        $updateData = [
          'status' => $request->status,
          'approved_by' => Auth::id(),
          'approved_at' => now(),
        ];

        if ($request->status === 'REJECTED') {
          $updateData['note'] = $pr->note . "\n[REASON]: " . $request->reason;
        }

        $pr->update($updateData);
      });

      return redirect()->route('purchase-requests.show', $id)->with('success', 'Status updated!');
    } catch (\Exception $e) {
      return back()->with('error', 'Update failed: ' . $e->getMessage());
    }
  }
}
