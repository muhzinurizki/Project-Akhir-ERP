@extends('layouts.app')

@section('title', 'Product Master | ERP Tekstil')
@section('page-title', 'Inventory Intelligence')

@section('content')
<div class="space-y-8 pb-10">
    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                <a href="#" class="hover:text-indigo-600 transition-colors">Master Data</a>
                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                <span class="text-slate-900">Product Catalog</span>
            </nav>
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Katalog Produk</h2>
            <p class="text-slate-500 font-medium mt-2 max-w-md">Pusat kendali SKU untuk material tekstil, WIP, dan Finished Goods.</p>
        </div>

        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-100 text-slate-600 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="file-down" class="w-4 h-4"></i>
                Export XLS
            </button>
            <a href="{{ route('products.create') }}"
                class="flex items-center gap-2 px-6 py-3 bg-slate-900 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-indigo-100">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Product
            </a>
        </div>
    </div>

    {{-- Stats Grid (Dinamis) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $totalSku = $products->total();
            $activeCount = $products->where('is_active', true)->count();
            // Menghitung stok rendah (< 10)
            $lowStockCount = $products->filter(fn($p) => $p->stock <= 10)->count();
            
            $kpis = [
                ['label' => 'Total SKU', 'val' => $totalSku, 'color' => 'indigo', 'icon' => 'box'],
                ['label' => 'Active Item', 'val' => $activeCount, 'color' => 'emerald', 'icon' => 'check-circle'],
                ['label' => 'Categories', 'val' => $categories->count(), 'color' => 'amber', 'icon' => 'layers'],
                ['label' => 'Low Stock', 'val' => $lowStockCount, 'color' => 'rose', 'icon' => 'alert-circle'],
            ];
        @endphp
        @foreach($kpis as $kpi)
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 group hover:shadow-xl hover:shadow-slate-200/40 transition-all duration-500">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center transition-all duration-500 shadow-inner
                    {{ $kpi['color'] == 'indigo' ? 'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white' : '' }}
                    {{ $kpi['color'] == 'emerald' ? 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white' : '' }}
                    {{ $kpi['color'] == 'amber' ? 'bg-amber-50 text-amber-600 group-hover:bg-amber-600 group-hover:text-white' : '' }}
                    {{ $kpi['color'] == 'rose' ? 'bg-rose-50 text-rose-600 group-hover:bg-rose-600 group-hover:text-white' : '' }}">
                    <i data-lucide="{{ $kpi['icon'] }}" class="w-7 h-7"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1.5">{{ $kpi['label'] }}</p>
                    <p class="text-2xl font-black text-slate-900 tracking-tighter">{{ $kpi['val'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group">
        {{-- Search & Filter Bar --}}
        <form action="{{ route('products.index') }}" method="GET"
            class="p-8 border-b border-slate-50 bg-slate-50/30 flex flex-col lg:flex-row gap-6 justify-between items-center">
            <div class="relative w-full lg:max-w-md">
                <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari SKU atau Nama Produk..."
                    class="w-full pl-14 pr-6 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-bold focus:ring-4 focus:ring-indigo-600/5 focus:border-indigo-600 transition-all outline-none shadow-inner tracking-tight">
            </div>
            
            <div class="flex items-center gap-3 w-full lg:w-auto">
                <select name="category" onchange="this.form.submit()"
                    class="flex-1 lg:flex-none bg-white border border-slate-100 rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-600 py-3.5 px-6 outline-none focus:ring-4 focus:ring-slate-900/5 transition-all cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ strtoupper($cat->name) }}
                        </option>
                    @endforeach
                </select>

                @if(request()->anyFilled(['search', 'category']))
                    <a href="{{ route('products.index') }}"
                        class="p-3.5 bg-rose-50 text-rose-600 rounded-2xl hover:bg-rose-600 hover:text-white transition-all shadow-sm" title="Clear Filters">
                        <i data-lucide="rotate-ccw" class="w-5 h-5"></i>
                    </a>
                @endif
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-white text-slate-400 uppercase text-[9px] font-black tracking-[0.25em]">
                    <tr>
                        <th class="px-10 py-6 border-b border-slate-50 text-center">No</th>
                        <th class="px-4 py-6 border-b border-slate-50">Identitas Produk</th>
                        <th class="px-6 py-6 border-b border-slate-50">Kategori</th>
                        {{-- Kolom Stok Baru --}}
                        <th class="px-6 py-6 border-b border-slate-50 text-center text-indigo-600">Inventory Level</th>
                        <th class="px-6 py-6 border-b border-slate-50 text-center">UOM</th>
                        <th class="px-6 py-6 border-b border-slate-50 text-center">Status</th>
                        <th class="px-10 py-6 border-b border-slate-50 text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/80 transition-all group/row">
                            <td class="px-10 py-6 text-center font-black text-slate-300 group-hover/row:text-indigo-600 transition-colors">
                                {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                            </td>
                            <td class="px-4 py-6">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover/row:bg-white group-hover/row:shadow-md transition-all">
                                        <i data-lucide="box" class="w-6 h-6"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="font-black text-slate-900 group-hover/row:text-indigo-600 transition-colors text-sm uppercase tracking-tight italic">{{ $product->name }}</span>
                                        <span class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                                            SKU: {{ $product->sku }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="px-3 py-1 bg-indigo-50/50 text-indigo-600 rounded-lg text-[10px] font-black uppercase tracking-widest border border-indigo-100/50">
                                    {{ $product->category?->name ?? 'N/A' }}
                                </span>
                            </td>
                            {{-- LOGIKA VISUALISASI STOK --}}
                            <td class="px-6 py-6 text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-sm font-black tracking-tighter {{ $product->stock <= 10 ? 'text-rose-600' : 'text-slate-900' }}">
                                        {{ number_format($product->stock, 0, ',', '.') }}
                                    </span>
                                    @if($product->stock <= 0)
                                        <span class="text-[8px] font-black px-2 py-0.5 bg-rose-100 text-rose-600 rounded uppercase tracking-widest">Empty</span>
                                    @elseif($product->stock <= 10)
                                        <span class="text-[8px] font-black px-2 py-0.5 bg-amber-100 text-amber-600 rounded uppercase tracking-widest">Low Stock</span>
                                    @else
                                        <span class="text-[8px] font-black px-2 py-0.5 bg-emerald-100 text-emerald-600 rounded uppercase tracking-widest">Good</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="text-xs font-black text-slate-500 uppercase">{{ $product->unit?->code ?? 'PCS' }}</span>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <div class="flex justify-center">
                                    @if($product->is_active)
                                        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black border border-emerald-100 shadow-sm">
                                            <span class="relative flex h-2 w-2">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                            </span>
                                            ACTIVE
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-400 text-[10px] font-black border border-slate-200">
                                            <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                            IDLE
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-10 py-6 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('products.edit', $product->id) }}"
                                        class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 border border-slate-100 rounded-xl transition-all hover:rotate-6 shadow-sm" title="Edit Data">
                                        <i data-lucide="pencil-line" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus data produk ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-100 rounded-xl transition-all hover:-rotate-6 shadow-sm" title="Delete SKU">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-10 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-4 border-2 border-dashed border-slate-100">
                                        <i data-lucide="package-search" class="w-10 h-10"></i>
                                    </div>
                                    <p class="text-slate-400 font-bold tracking-tight italic">SKU tidak ditemukan dalam database...</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-50">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection