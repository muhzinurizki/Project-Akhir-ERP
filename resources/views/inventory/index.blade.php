@extends('layouts.app')

@section('title', 'Saldo Stok Inventaris | Inventory System')

@section('content')
<div class="max-w-7xl mx-auto p-8 pb-24">
    {{-- Header Section: Professional & Dynamic --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div class="flex items-center gap-5">
            <div class="relative">
                <div class="p-4 bg-slate-900 rounded-[1.5rem] shadow-xl shadow-slate-200">
                    <i data-lucide="package" class="w-8 h-8 text-white"></i>
                </div>
                <div class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full"></div>
            </div>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none mb-2">Stock Balances</h1>
                <p class="text-slate-400 font-medium flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                    Monitor real-time ketersediaan barang di seluruh gudang.
                </p>
            </div>
        </div>

        <div class="flex items-center gap-4 bg-white p-2 rounded-3xl shadow-sm border border-slate-100">
            <a href="{{ route('inventory.create-in') }}" class="group flex items-center gap-2 px-6 py-3 bg-emerald-500 text-white rounded-2xl font-black hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100 active:scale-95 text-sm">
                <i data-lucide="plus-circle" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
                Stock In
            </a>
            <a href="{{ route('inventory.create-out') }}" class="group flex items-center gap-2 px-6 py-3 bg-rose-500 text-white rounded-2xl font-black hover:bg-rose-600 transition-all shadow-lg shadow-rose-100 active:scale-95 text-sm">
                <i data-lucide="minus-circle" class="w-5 h-5 group-hover:-rotate-90 transition-transform"></i>
                Stock Out
            </a>
        </div>
    </div>

    {{-- Stats Cards: Improved with Overlays --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        {{-- Total SKU --}}
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-slate-50 rounded-xl text-slate-400"><i data-lucide="layers" class="w-5 h-5"></i></div>
            </div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Total SKU</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">
                {{ $stocks->unique('product_id')->count() }}
                <span class="text-xs font-bold text-slate-300 uppercase tracking-widest ml-1">Items</span>
            </h3>
        </div>

        {{-- Total Qty --}}
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-indigo-50 rounded-xl text-indigo-400"><i data-lucide="boxes" class="w-5 h-5"></i></div>
            </div>
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Total Quantity</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">
                {{ number_format($stocks->sum('quantity'), 0) }}
                <span class="text-xs font-bold text-slate-300 uppercase tracking-widest ml-1">Units</span>
            </h3>
        </div>

        {{-- Low Stock Alert --}}
        <div class="bg-amber-500 p-7 rounded-[2.5rem] shadow-2xl shadow-amber-200 text-white relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-100 mb-1">Low Stock Alert</p>
                <h3 class="text-3xl font-black leading-none">{{ $stocks->where('quantity', '<=', 10)->count() }} SKU</h3>
                <div class="mt-4 flex items-center gap-2 px-3 py-1 bg-amber-400/50 rounded-full w-fit text-[10px] font-bold">
                    <i data-lucide="info" class="w-3 h-3"></i> Needs Restock
                </div>
            </div>
            <i data-lucide="alert-triangle" class="w-24 h-24 absolute -right-6 -bottom-6 text-white opacity-20 group-hover:scale-110 group-hover:-rotate-12 transition-all duration-500"></i>
        </div>

        {{-- Active Locations --}}
        <div class="bg-slate-900 p-7 rounded-[2.5rem] shadow-2xl shadow-slate-200 text-white relative overflow-hidden group">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-1">Active Locations</p>
                <h3 class="text-3xl font-black leading-none">{{ $stocks->unique('warehouse_id')->count() }} </h3>
                <div class="mt-4 flex items-center gap-2 px-3 py-1 bg-slate-800 rounded-full w-fit text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                    Managed Warehouses
                </div>
            </div>
            <i data-lucide="map-pin" class="w-24 h-24 absolute -right-6 -bottom-6 text-slate-800 opacity-50 group-hover:translate-x-2 transition-all duration-500"></i>
        </div>
    </div>

    {{-- Main Inventory Table Section --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        {{-- Custom Toolbar --}}
        <form action="{{ route('inventory.index') }}" method="GET" class="p-8 border-b border-slate-50 flex flex-wrap justify-between items-center gap-6 bg-slate-50/20">
            <div class="relative w-full md:w-[28rem]">
                <i data-lucide="search" class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari SKU atau Nama Produk..."
                       class="w-full pl-14 pr-6 py-4 bg-white border-none rounded-2xl text-sm font-bold shadow-sm ring-1 ring-slate-100 focus:ring-2 focus:ring-slate-900 transition-all placeholder:text-slate-300">
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-56">
                    <i data-lucide="warehouse" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <select name="warehouse" class="w-full pl-11 pr-4 py-4 text-xs font-black uppercase tracking-tight border-none rounded-2xl bg-white ring-1 ring-slate-100 focus:ring-2 focus:ring-slate-900 appearance-none">
                        <option value="">All Warehouses</option>
                        @foreach($stocks->unique('warehouse_id') as $s)
                            <option value="{{ $s->warehouse_id }}" {{ request('warehouse') == $s->warehouse_id ? 'selected' : '' }}>
                                {{ $s->warehouse->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 active:scale-95">
                    Filter
                </button>
            </div>
        </form>

        {{-- Table Container --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-10 py-6">Product Information</th>
                        <th class="px-6 py-6 text-center">Warehouse Location</th>
                        <th class="px-6 py-6 text-right">Available Stock</th>
                        <th class="px-10 py-6 text-right">Log History</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($stocks as $stock)
                    <tr class="hover:bg-slate-50/80 transition-all group">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-5">
                                <div class="relative">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-white group-hover:shadow-md group-hover:scale-110 transition-all duration-300">
                                        <i data-lucide="box" class="w-7 h-7"></i>
                                    </div>
                                    @if($stock->quantity <= 10)
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-rose-500 rounded-full border-2 border-white animate-bounce"></div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-black text-slate-800 uppercase tracking-tight text-base leading-tight">
                                        {{ $stock->product->name }}
                                    </div>
                                    <div class="flex items-center gap-3 mt-1.5">
                                        <span class="text-[10px] font-mono font-black text-slate-500 px-2.5 py-1 bg-slate-100 rounded-lg group-hover:bg-white transition-colors">
                                            {{ $stock->product->code }}
                                        </span>
                                        <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">
                                            {{ $stock->product->category->name ?? 'No Category' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex justify-center">
                                <div class="flex items-center gap-2.5 text-slate-600 font-black text-[11px] uppercase tracking-tight bg-white px-4 py-2 rounded-2xl border border-slate-100 group-hover:border-slate-300 transition-all shadow-sm">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400"></i>
                                    {{ $stock->warehouse->name }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-right">
                            <div class="flex flex-col items-end">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-3xl font-black {{ $stock->quantity <= 10 ? 'text-rose-600' : 'text-slate-900' }} tracking-tighter">
                                        {{ number_format($stock->quantity, 0) }}
                                    </span>
                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                        {{ $stock->product->unit->name ?? 'Unit' }}
                                    </span>
                                </div>
                                {{-- Visual Stock Bar --}}
                                <div class="w-24 h-1.5 bg-slate-100 rounded-full mt-2 overflow-hidden">
                                    <div class="h-full {{ $stock->quantity <= 10 ? 'bg-rose-500' : 'bg-emerald-500' }} rounded-full"
                                         style="width: {{ min(($stock->quantity / 100) * 100, 100) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <a href="{{ route('inventory.movements', ['product_id' => $stock->product_id, 'warehouse_id' => $stock->warehouse_id]) }}"
                               class="inline-flex items-center justify-center p-3.5 bg-white border border-slate-100 text-slate-400 rounded-2xl hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all group/btn shadow-sm hover:shadow-xl hover:-translate-y-0.5">
                                <i data-lucide="history" class="w-5 h-5 transition-transform group-hover/btn:rotate-[-30deg]"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-6">
                                    <i data-lucide="box-select" class="w-12 h-12 text-slate-200"></i>
                                </div>
                                <h4 class="text-xl font-black text-slate-900 uppercase tracking-tight">Data Stok Kosong</h4>
                                <p class="text-slate-400 text-sm mt-2 max-w-xs mx-auto">Sistem tidak menemukan saldo barang untuk kriteria pencarian ini.</p>
                                <a href="{{ route('inventory.create-in') }}" class="mt-6 px-6 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-xs uppercase tracking-widest">
                                    Lakukan Stock In
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Pastikan lucide dimuat jika tidak di app.js
    document.addEventListener("DOMContentLoaded", function() {
        if(typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection