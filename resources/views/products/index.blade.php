@extends('layouts.app')

@section('title', 'Product Master')
@section('page-title', 'Inventory')

@section('content')
<div class="space-y-8">
  {{-- Header Section --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <a href="#" class="hover:text-slate-900 transition-colors">Master Data</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">Products</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Katalog Produk</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Kelola seluruh material tekstil, barang setengah jadi, dan
        produk jadi.</p>
    </div>

    <div class="flex items-center gap-3">
      <button
        class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all shadow-sm">
        <i data-lucide="file-down" class="w-4 h-4 text-slate-400"></i>
        Export Report
      </button>
      <a href="{{ route('products.create') }}"
        class="flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-200">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Produk
      </a>
    </div>
  </div>

  {{-- Stats Grid --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @php
    $kpis = [
    ['label' => 'Total SKU', 'val' => $products->total(), 'color' => 'indigo', 'icon' => 'box'],
    ['label' => 'Produk Aktif', 'val' => $products->where('is_active', true)->count(), 'color' => 'emerald', 'icon' =>
    'check-circle'],
    ['label' => 'Total Kategori', 'val' => $categories->count(), 'color' => 'amber', 'icon' => 'layers'],
    ['label' => 'Stok Rendah', 'val' => '12', 'color' => 'rose', 'icon' => 'alert-circle'],
    ];
    @endphp
    @foreach($kpis as $kpi)
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
      <div class="w-12 h-12 rounded-xl flex items-center justify-center
                {{ $kpi['color'] == 'indigo' ? 'bg-indigo-50 text-indigo-600' : '' }}
                {{ $kpi['color'] == 'emerald' ? 'bg-emerald-50 text-emerald-600' : '' }}
                {{ $kpi['color'] == 'amber' ? 'bg-amber-50 text-amber-600' : '' }}
                {{ $kpi['color'] == 'rose' ? 'bg-rose-50 text-rose-600' : '' }}">
        <i data-lucide="{{ $kpi['icon'] }}" class="w-6 h-6"></i>
      </div>
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $kpi['label'] }}</p>
        <p class="text-xl font-extrabold text-slate-900">{{ $kpi['val'] }}</p>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
    {{-- Search & Filter Bar --}}
    <form action="{{ route('products.index') }}" method="GET"
      class="p-6 border-b border-slate-50 bg-slate-50/30 flex flex-col sm:flex-row gap-4 justify-between">
      <div class="relative max-w-sm w-full">
        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU..."
          class="w-full pl-11 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all outline-none font-medium">
      </div>
      <div class="flex items-center gap-2">
        <select name="category" onchange="this.form.submit()"
          class="bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 py-2.5 px-4 outline-none focus:border-slate-900 transition-all cursor-pointer">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('category')==$cat->id ? 'selected' : '' }}>
            {{ $cat->name }}
          </option>
          @endforeach
        </select>
        @if(request()->anyFilled(['search', 'category']))
        <a href="{{ route('products.index') }}"
          class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition-colors" title="Clear Filter">
          <i data-lucide="x-circle" class="w-5 h-5"></i>
        </a>
        @endif
      </div>
    </form>

    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left border-collapse">
        <thead class="bg-white text-slate-400 uppercase text-[10px] font-bold tracking-[0.15em]">
          <tr>
            <th class="px-8 py-5 border-b border-slate-50 text-center w-16">#</th>
            <th class="px-4 py-5 border-b border-slate-50">Produk & SKU</th>
            <th class="px-6 py-5 border-b border-slate-50">Kategori</th>
            <th class="px-6 py-5 border-b border-slate-50 text-center">Unit</th>
            <th class="px-6 py-5 border-b border-slate-50">Tipe Barang</th>
            <th class="px-6 py-5 border-b border-slate-50 text-center">Status</th>
            <th class="px-8 py-5 border-b border-slate-50 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($products as $product)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5 text-center font-bold text-slate-300">
              {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
            </td>
            <td class="px-4 py-5">
              <div class="flex items-center gap-4">
                <div
                  class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                  <i data-lucide="package" class="w-5 h-5"></i>
                </div>
                <div class="flex flex-col">
                  <span class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors leading-tight">{{
                    $product->name }}</span>
                  <span
                    class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-widest bg-slate-50 px-1.5 py-0.5 rounded border border-slate-100 w-fit">{{
                    $product->sku }}</span>
                </div>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <div class="w-1.5 h-1.5 rounded-full {{ $product->category ? 'bg-indigo-400' : 'bg-slate-300' }}"></div>
                <span class="{{ $product->category ? 'text-slate-600 font-bold' : 'text-slate-400 italic' }}">
                  {{ $product->category?->name ?? 'Uncategorized' }}
                </span>
              </div>
            </td>
            <td class="px-6 py-4 text-center font-bold text-slate-500">
              {{ $product->unit?->code ?? '-' }}
            </td>
            <td class="px-6 py-4">
              <span
                class="px-3 py-1 rounded-lg text-[10px] font-black bg-white text-slate-600 border border-slate-200 uppercase tracking-tighter">
                {{ str_replace('_', ' ', $product->type) }}
              </span>
            </td>
            <td class="px-6 py-4">
              <div class="flex justify-center">
                @if($product->is_active)
                <span
                  class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black border border-emerald-100">
                  <span class="w-1 h-1 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.6)]"></span>
                  ACTIVE
                </span>
                @else
                <span
                  class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 text-slate-400 text-[10px] font-black border border-slate-100">
                  <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                  INACTIVE
                </span>
                @endif
              </div>
            </td>
            <td class="px-8 py-4 text-right">
              <div class="flex justify-end gap-1">
                <a href="{{ route('products.edit', $product->id) }}"
                  class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all"
                  title="Edit">
                  <i data-lucide="edit-3" class="w-4 h-4"></i>
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                  onsubmit="return confirm('Hapus produk ini?')">
                  @csrf @method('DELETE')
                  <button type="submit"
                    class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all"
                    title="Hapus">
                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-8 py-20 text-center text-slate-400 italic">
              Belum ada produk yang sesuai dengan kriteria pencarian.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/20">
      {{ $products->links() }}
    </div>
  </div>
</div>
@endsection