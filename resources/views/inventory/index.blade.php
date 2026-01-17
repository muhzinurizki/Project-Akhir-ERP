@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Inventory Balances</h1>
            <p class="text-sm text-slate-500 font-medium">Monitoring real-time saldo stok di seluruh gudang.</p>
        </div>
        <a href="{{ route('inventory.create') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl transition-all shadow-sm shadow-indigo-100 text-sm font-bold">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            Record Stock Movement
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="package" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total SKU</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['total_skus'] }}</p>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="alert-circle" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Critical Stock</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['low_stock_count'] }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                <i data-lucide="activity" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Movements Today</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['total_movements_today'] }}</p>
            </div>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex flex-col md:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-slate-800 px-2">Stock Catalogue</h3>
            <form action="{{ route('inventory.index') }}" method="GET" class="relative group w-full md:w-80">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari SKU atau Nama Kain..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border-none rounded-2xl text-sm focus:ring-2 focus:ring-indigo-500 transition-all">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50">
                    <tr class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                        <th class="px-8 py-5">Product Details</th>
                        <th class="px-8 py-5">Category</th>
                        <th class="px-8 py-5 text-right">Stock Balance</th>
                        <th class="px-8 py-5 text-center">Ledger</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($products as $p)
                    <tr class="hover:bg-slate-50/30 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black text-indigo-500 mb-1 tracking-tighter italic">[{{ $p->sku }}]</span>
                                <span class="font-bold text-slate-700">{{ $p->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="text-xs font-semibold text-slate-500">{{ $p->category->name }}</span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex flex-col items-end">
                                <span class="text-2xl font-black tracking-tighter {{ $p->stock_total <= $p->min_stock_level ? 'text-rose-500' : 'text-slate-800' }}">
                                    {{ number_format($p->stock_total, 0) }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->unit->code }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <a href="{{ route('inventory.detail', $p->id) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                                <i data-lucide="history" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/20 border-t border-slate-50">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection