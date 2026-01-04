@extends('layouts.app')

@section('title', 'Edit Product')
@section('page-title', 'Katalog Produk')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
  {{-- Breadcrumb & Navigation --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('products.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar
    </a>

    <div class="flex items-center gap-2">
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID Produk:</span>
      <span class="text-xs font-mono font-bold bg-slate-100 px-2 py-1 rounded text-slate-600">{{ $product->id }}</span>
    </div>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Form --}}
    <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Edit Detail Produk</h2>
        <p class="text-sm text-slate-500 font-medium mt-1">Perbarui informasi teknis dan status inventaris produk.</p>
      </div>
      <div class="hidden md:block">
        @if($product->is_active)
        <span
          class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[11px] font-bold border border-emerald-100 flex items-center gap-2">
          <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
          PRODUK AKTIF
        </span>
        @else
        <span
          class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-400 text-[11px] font-bold border border-slate-200 flex items-center gap-2">
          <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
          NON-AKTIF
        </span>
        @endif
      </div>
    </div>

    <form method="POST" action="{{ route('products.update', $product) }}" class="p-10 space-y-8">
      @csrf
      @method('PUT')

      {{-- Section 1: Informasi Utama --}}
      <div class="space-y-6">
        <div class="flex items-center gap-3 mb-2">
          <i data-lucide="info" class="w-5 h-5 text-indigo-500"></i>
          <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Informasi Dasar</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          {{-- SKU Field --}}
          <div class="space-y-2">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">SKU / Kode
              Produk</label>
            <div class="relative group">
              <i data-lucide="hash" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
              <input name="sku" value="{{ old('sku', $product->sku) }}"
                class="w-full pl-11 pr-4 py-3 bg-slate-50 border @error('sku') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all shadow-sm"
                required>
            </div>
            @error('sku') <p class="text-[11px] text-rose-500 mt-1 font-medium ml-1">{{ $message }}</p> @enderror
          </div>

          {{-- Name Field --}}
          <div class="space-y-2">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Nama Produk</label>
            <div class="relative group">
              <i data-lucide="package" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
              <input name="name" value="{{ old('name', $product->name) }}"
                class="w-full pl-11 pr-4 py-3 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all shadow-sm"
                required>
            </div>
            @error('name') <p class="text-[11px] text-rose-500 mt-1 font-medium ml-1">{{ $message }}</p> @enderror
          </div>
        </div>
      </div>

      <hr class="border-slate-50">

      {{-- Section 2: Klasifikasi --}}
      <div class="space-y-6">
        <div class="flex items-center gap-3 mb-2">
          <i data-lucide="layers" class="w-5 h-5 text-indigo-500"></i>
          <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Klasifikasi & Satuan</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="space-y-2">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Kategori Produk</label>
            <select name="product_category_id"
              class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer shadow-sm">
              @foreach($categories as $category)
              <option value="{{ $category->id }}" @selected(old('product_category_id', $product->product_category_id) ==
                $category->id)>
                {{ $category->name }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="space-y-2">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Satuan (UoM)</label>
            <select name="unit_id"
              class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer shadow-sm">
              @foreach($units as $unit)
              <option value="{{ $unit->id }}" @selected(old('unit_id', $product->unit_id) == $unit->id)>
                {{ $unit->code }} — {{ $unit->name }}
              </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      {{-- Section 3: Inventory Type --}}
      <div class="space-y-4">
        <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Tipe Inventaris</label>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          @php
          $types = [
          'raw_material' => ['label' => 'Raw Material', 'icon' => 'box'],
          'semi_finished' => ['label' => 'Semi Finished', 'icon' => 'component'],
          'finished' => ['label' => 'Finished Goods', 'icon' => 'check-square']
          ];
          @endphp

          @foreach($types as $value => $data)
          <label
            class="relative flex flex-col items-center justify-center border-2 border-slate-100 rounded-[1.5rem] p-6 cursor-pointer hover:border-indigo-200 hover:bg-indigo-50/20 transition-all group">
            <input type="radio" name="type" value="{{ $value }}" class="absolute opacity-0 peer" @checked(old('type',
              $product->type) == $value)>

            <div
              class="absolute inset-0 border-2 border-transparent peer-checked:border-slate-900 peer-checked:bg-white peer-checked:shadow-xl peer-checked:shadow-slate-200/50 rounded-[1.5rem] transition-all">
            </div>

            <div class="relative z-10 flex flex-col items-center">
              <i data-lucide="{{ $data['icon'] }}"
                class="w-6 h-6 mb-2 text-slate-400 peer-checked:text-slate-900 transition-colors"></i>
              <span
                class="text-[11px] font-extrabold text-slate-400 peer-checked:text-slate-900 uppercase tracking-widest">{{
                $data['label'] }}</span>
            </div>

            {{-- Checkmark Icon for Selected --}}
            <div class="absolute top-3 right-3 opacity-0 peer-checked:opacity-100 transition-opacity z-10">
              <div class="w-5 h-5 rounded-full bg-slate-900 flex items-center justify-center">
                <i data-lucide="check" class="w-3 h-3 text-white"></i>
              </div>
            </div>
          </label>
          @endforeach
        </div>
      </div>

      {{-- Section 4: Status Toggle --}}
      <div
        class="p-6 bg-slate-900 rounded-[2rem] text-white flex items-center justify-between shadow-lg shadow-slate-200">
        <div class="flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10">
            <i data-lucide="power" class="w-6 h-6 text-emerald-400"></i>
          </div>
          <div>
            <p class="font-bold text-sm tracking-tight">Status Produk</p>
            <p class="text-[11px] text-slate-400 font-medium">Nonaktifkan jika produk sudah tidak diproduksi.</p>
          </div>
        </div>

        <label class="relative inline-flex items-center cursor-pointer scale-110">
          <input type="hidden" name="is_active" value="0">
          <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active',
            $product->is_active))>
          <div
            class="w-12 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500">
          </div>
        </label>
      </div>

      {{-- Form Actions --}}
      <div class="flex items-center justify-end gap-4 pt-6">
        <a href="{{ route('products.index') }}"
          class="px-8 py-3.5 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
          Batalkan Perubahan
        </a>
        <button type="submit"
          class="px-10 py-3.5 bg-slate-900 text-white text-sm font-bold rounded-2xl hover:bg-slate-800 shadow-xl shadow-slate-200 transition-all flex items-center gap-2 active:scale-95">
          <i data-lucide="save" class="w-4 h-4"></i>
          Simpan Perubahan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection