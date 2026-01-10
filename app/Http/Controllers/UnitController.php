<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::withCount('products')->orderBy('name', 'asc')->get();
        return view('units.index', compact('units'));
    }

    public function create()
    {
        return view('units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:units,code',
            'name' => 'required|string|max:255',
        ]);

        Unit::create($validated);
        return redirect()->route('units.index')->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        return view('units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:units,code,' . $unit->id,
            'name' => 'required|string|max:255',
        ]);

        $unit->update($validated);
        return redirect()->route('units.index')->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        if ($unit->products()->count() > 0) {
            return back()->with('error', 'Satuan tidak bisa dihapus karena sedang digunakan oleh produk.');
        }

        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Satuan berhasil dihapus.');
    }
}