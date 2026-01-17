@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8 flex items-center gap-5 px-2">
        <a href="{{ route('inventory.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
            <i data-lucide="chevron-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Record Stock Movement</h1>
            <p class="text-sm text-slate-500">Input transaksi barang masuk (IN) atau barang keluar (OUT).</p>
        </div>
    </div>

    <form action="{{ route('inventory.store') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        @csrf
        <div class="p-10 space-y-10">
            {{-- Selection Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Select Product SKU</label>
                    <select name="product_id" required class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-bold p-4 focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer">
                        <option value="">Choose item...</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}">{{ $p->sku }} - {{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Warehouse Location</label>
                    <select name="warehouse_id" required class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-bold p-4 focus:ring-2 focus:ring-indigo-500 transition-all appearance-none cursor-pointer">
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Type & Quantity Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-50">
                <div class="space-y-4">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1">Movement Type</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center justify-center p-4 rounded-2xl border border-slate-100 bg-slate-50 cursor-pointer has-[:checked]:bg-emerald-600 has-[:checked]:text-white transition-all font-bold uppercase text-xs">
                            <input type="radio" name="type" value="IN" class="sr-only" checked>
                            <span>Stock In</span>
                        </label>
                        <label class="relative flex items-center justify-center p-4 rounded-2xl border border-slate-100 bg-slate-50 cursor-pointer has-[:checked]:bg-rose-600 has-[:checked]:text-white transition-all font-bold uppercase text-xs">
                            <input type="radio" name="type" value="OUT" class="sr-only">
                            <span>Stock Out</span>
                        </label>
                    </div>
                </div>
                <div class="space-y-4">
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-1">Quantity (Angka Bulat)</label>
                    <div class="relative group">
                        <input type="number" name="quantity" min="1" step="1" oninput="this.value = Math.abs(this.value)" required placeholder="0" 
                               class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-black text-3xl p-4 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-bold text-slate-300 group-focus-within:text-indigo-400">UNIT/PCS</span>
                    </div>
                </div>
            </div>

            {{-- Ref & Note Row --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-50">
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1 text-xs">Reference Number</label>
                    <input type="text" name="reference" placeholder="PO-001, SJ-002, etc." class="w-full rounded-2xl border-slate-100 bg-slate-50 font-semibold p-4 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-[0.2em] ml-1 text-xs">Additional Note</label>
                    <input type="text" name="note" placeholder="Alasan mutasi..." class="w-full rounded-2xl border-slate-100 bg-slate-50 font-semibold p-4 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>
        </div>

        <div class="p-10 bg-slate-50/50 flex gap-4">
            <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase tracking-[0.2em] text-xs">
                Submit Transaction
            </button>
            <a href="{{ route('inventory.index') }}" class="px-10 py-4 bg-white border border-slate-200 text-slate-400 rounded-2xl font-bold hover:bg-slate-50 transition-all uppercase tracking-[0.2em] text-xs text-center">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection