<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::latest()->paginate(10);
        return view('warehouses.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:warehouses,code',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        Warehouse::create($validated);

        return redirect()
            ->route('warehouses.index')
            ->with('success', 'Warehouse berhasil ditambahkan');
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouses.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'code' => 'required|unique:warehouses,code,' . $warehouse->id,
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $warehouse->update($validated);

        return redirect()
            ->route('warehouses.index')
            ->with('success', 'Warehouse berhasil diperbarui');
    }
}
