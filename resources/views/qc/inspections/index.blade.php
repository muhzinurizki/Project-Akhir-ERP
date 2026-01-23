@extends('layouts.app')

@section('title', 'Product Inspection')
@section('page-title', 'Quality Control')

@section('content')
<div class="space-y-8">

  {{-- Header --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <span>Quality Control</span>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">Product Inspection</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
        Product Inspection
      </h2>
      <p class="text-sm text-slate-500 font-medium mt-1">
        Products waiting for quality inspection.
      </p>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">

    {{-- Search & Filter Bar --}}
    <form method="GET"
          action="{{ route('qc-inspections.index') }}"
          class="p-6 border-b border-slate-50 bg-slate-50/30 flex flex-col sm:flex-row gap-4 justify-between">

      {{-- Search --}}
      <div class="relative max-w-sm w-full">
        <i data-lucide="search"
           class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search product name or SKU..."
               class="w-full pl-11 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium
                      focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition">
      </div>

      {{-- Filters --}}
      <div class="flex items-center gap-2">
        {{-- Category --}}
        <select name="category"
                onchange="this.form.submit()"
                class="bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 py-2.5 px-4 cursor-pointer">
          <option value="">All Categories</option>
          @foreach($categories as $category)
            <option value="{{ $category->id }}"
              @selected(request('category') == $category->id)>
              {{ $category->name }}
            </option>
          @endforeach
        </select>

        {{-- Type --}}
        <select name="type"
                onchange="this.form.submit()"
                class="bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 py-2.5 px-4 cursor-pointer">
          <option value="">All Types</option>
          <option value="raw_material" @selected(request('type') == 'raw_material')>Raw Material</option>
          <option value="semi_finished" @selected(request('type') == 'semi_finished')>Semi Finished</option>
          <option value="finished" @selected(request('type') == 'finished')>Finished Goods</option>
        </select>

        {{-- Clear Filter --}}
        @if(request()->anyFilled(['search', 'category', 'type']))
          <a href="{{ route('qc-inspections.index') }}"
             class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition"
             title="Clear Filter">
            <i data-lucide="x-circle" class="w-5 h-5"></i>
          </a>
        @endif
      </div>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-white text-slate-400 uppercase text-[10px] font-bold tracking-widest">
          <tr>
            <th class="px-8 py-5 text-center w-16">#</th>
            <th class="px-6 py-5">Product</th>
            <th class="px-6 py-5">Category</th>
            <th class="px-6 py-5 text-center">Unit</th>
            <th class="px-6 py-5">Type</th>
            <th class="px-6 py-5 text-center">Status</th>
            <th class="px-8 py-5 text-right">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-50">
          @forelse($products as $product)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5 text-center font-bold text-slate-300">
              {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
            </td>

            <td class="px-6 py-5">
              <div class="font-bold text-slate-900 group-hover:text-indigo-600 transition">
                {{ $product->name }}
              </div>
              <div class="text-[10px] uppercase tracking-widest text-slate-400">
                {{ $product->sku }}
              </div>
            </td>

            <td class="px-6 py-5">
              <span class="text-slate-600 font-bold">
                {{ $product->category?->name ?? '-' }}
              </span>
            </td>

            <td class="px-6 py-5 text-center font-bold text-slate-500">
              {{ $product->unit?->code ?? '-' }}
            </td>

            <td class="px-6 py-5">
              <span
                class="px-3 py-1 rounded-lg text-[10px] font-black bg-white text-slate-600 border border-slate-200 uppercase">
                {{ str_replace('_', ' ', $product->type) }}
              </span>
            </td>

            <td class="px-6 py-5">
              <div class="flex justify-center">
                <span
                  class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-black border border-amber-100">
                  WAITING QC
                </span>
              </div>
            </td>

            <td class="px-8 py-5 text-right">
              <a href="{{ route('qc-inspections.create', $product->id) }}"
                 class="px-4 py-2 bg-slate-900 text-white text-xs font-bold rounded-xl
                        hover:bg-slate-800 transition shadow">
                Inspect
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-8 py-20 text-center text-slate-400 italic">
              No products waiting for inspection.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/20">
      {{ $products->links() }}
    </div>

  </div>
</div>
@endsection
