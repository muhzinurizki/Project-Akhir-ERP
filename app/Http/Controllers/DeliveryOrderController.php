<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\SalesOrder;
use App\Models\StockLedger;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryOrderController extends Controller
{
    public function index()
    {
        $deliveryOrders = DeliveryOrder::with(['salesOrder.customer', 'warehouse', 'user'])
            ->latest()
            ->paginate(10);
            
        return view('delivery_orders.index', compact('deliveryOrders'));
    }

    public function create($so_id)
    {
        // Pastikan SO yang dipilih statusnya sudah CONFIRMED
        $salesOrder = SalesOrder::with('items.product', 'customer')->findOrFail($so_id);
        
        if ($salesOrder->status !== 'CONFIRMED') {
            return back()->with('error', 'Hanya Sales Order yang berstatus CONFIRMED yang dapat diproses.');
        }

        $warehouses = Warehouse::all();
        
        // Generate DO Number otomatis: DO-20260117-XXXX
        $nextId = DeliveryOrder::max('id') + 1;
        $do_number = 'DO-' . date('Ymd') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('delivery_orders.create', compact('salesOrder', 'warehouses', 'do_number'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sales_order_id' => 'required|exists:sales_orders,id',
            'warehouse_id'   => 'required|exists:warehouses,id',
            'delivery_date'  => 'required|date',
            'do_number'      => 'required|unique:delivery_orders,do_number',
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan Header Delivery Order
            $do = DeliveryOrder::create([
                'do_number'      => $request->do_number,
                'sales_order_id' => $request->sales_order_id,
                'warehouse_id'   => $request->warehouse_id,
                'delivery_date'  => $request->delivery_date,
                'user_id'        => auth()->id(),
            ]);

            $salesOrder = SalesOrder::with('items')->find($request->sales_order_id);

            foreach ($salesOrder->items as $item) {
                // 2. Ambil saldo terakhir produk tersebut (Global/Warehouse specific tergantung kebutuhan)
                $lastBalance = StockLedger::where('product_id', $item->product_id)
                    ->orderBy('id', 'desc')
                    ->value('balance_after') ?? 0;

                // 3. Rekam Mutasi Stok KELUAR (OUT)
                StockLedger::create([
                    'product_id'    => $item->product_id,
                    'warehouse_id'  => $request->warehouse_id,
                    'user_id'       => auth()->id(),
                    'type'          => 'OUT',
                    'quantity'      => -$item->quantity, // Nilai negatif untuk pengeluaran
                    'balance_after' => $lastBalance - $item->quantity,
                    'reference'     => $do->do_number,
                    'note'          => "Pengiriman Pesanan " . $salesOrder->so_number,
                ]);

                // 4. Update status jumlah terkirim di detail Sales Order
                $item->increment('shipped_quantity', $item->quantity);
            }

            // 5. Update Status SO jika semua barang sudah diproses (Opsional)
            // $salesOrder->update(['status' => 'SHIPPED']);

            DB::commit();
            return redirect()->route('delivery-orders.index')->with('success', 'Barang berhasil dikirim dan stok telah dipotong.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pengiriman: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $do = DeliveryOrder::with(['salesOrder.items.product', 'warehouse', 'user', 'salesOrder.customer'])->findOrFail($id);
        return view('delivery_orders.show', compact('do'));
    }
}