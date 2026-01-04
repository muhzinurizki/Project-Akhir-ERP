<?php

namespace App\Http\Controllers;

use App\Models\ProductWarehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $stocks = ProductWarehouse::with(['product', 'warehouse'])
            ->when($request->warehouse_id, function($q) use ($request) {
                $q->where('warehouse_id', $request->warehouse_id);
            })
            ->where('quantity', '>', 0)
            ->paginate(15);

        return view('inventory.stocks.index', compact('stocks'));
    }
}