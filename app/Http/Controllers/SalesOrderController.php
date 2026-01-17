<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesOrderController extends Controller
{
    public function index()
    {
        $orders = SalesOrder::with('customer', 'user')->latest()->paginate(10);
        return view('sales_orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        // Generate nomor SO otomatis: SO-20260117-001
        $nextId = SalesOrder::max('id') + 1;
        $so_number = 'SO-' . date('Ymd') . '-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);

        return view('sales_orders.create', compact('customers', 'products', 'so_number'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'order_date' => 'required|date',
            'items' => 'required|array',
            'items.*.product_id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $so = SalesOrder::create([
                'so_number' => $request->so_number,
                'customer_id' => $request->customer_id,
                'order_date' => $request->order_date,
                'note' => $request->note,
                'user_id' => auth()->id(),
                'status' => 'DRAFT'
            ]);

            foreach ($request->items as $item) {
                $so->items()->create($item);
            }

            DB::commit();
            return redirect()->route('sales-orders.index')->with('success', 'Sales Order berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $order = SalesOrder::with('customer', 'items.product', 'user')->findOrFail($id);
        return view('sales_orders.show', compact('order'));
    }
}