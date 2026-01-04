@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Katalog Produk')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
  {{-- Back Link --}}
  <div class="mb-8">
    <a href="{{ route('products.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar Produk
    </a>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Form --}}
    <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30">
      <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Registrasi Produk Baru</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Lengkapi informasi di bawah untuk mendaftarkan barang ke dalam
        sistem ERP.</p>
    </div>

    <form method="POST" action="{{ route('products.store') }}" class="p-10 space-y-8">
      @csrf

      {{-- Section 1: Identitas Produk --}}
      <div class="space-y-6">
        <div class="flex items-center gap-3 mb-2">
          <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
            <i data-lucide="tag" class="w-4 h-4 text-indigo-600"></i>
          </div>
          <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Identitas Produk</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          {{-- SKU Field --}}
          <div class="space-y-2">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">SKU / Kode Unik</label>
            <div class="relative group">
              <i data-lucide="barcode" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
              <input name="sku" value="{{ old('sku') }}" placeholder="Contoh: FAB-COT-001"
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border @error('sku') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all shadow-sm">
            </div>
            @error('sku') <p class="text-[11px] text-rose-500 mt-1 font-medium ml-1 italic">{{ $message }}</p> @enderror
          </div>

          {{-- Name Field --}}
          <div class="space-y-2">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Nama Produk</label>
            <div class="relative group">
              <i data-lucide="type" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
              <input name="name" value="{{ old('name') }}" placeholder="Contoh: Cotton Combed 30s Black"
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all shadow-sm">
            </div>
            @error('name') <p class="text-[11px] text-rose-500 mt-1 font-medium ml-1 italic">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>

      <hr class="border-slate-50">

      {{-- Section 2: Klasifikasi --}}
      <div class="space-y-6">
        <div class="flex items-center gap-3 mb-2">
          <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
            <i data-lucide="layers" class="w-4 h-4 text-indigo-600"></i>
          </div>
          <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Kategori & Satuan</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <div class="space-y-2 text-slate-900">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Kategori</label>
            <select name="product_category_id"
              class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3.5 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer shadow-sm">
              <option value="" disabled selected>Pilih Kategori</option>
              @foreach($categories as $category)
              <option value="{{ $category->id }}" {{ old('product_category_id')==$category->id ? 'selected' : '' }}>
                {{ $category->name }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="space-y-2 text-slate-900">
            <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Satuan Dasar
              (UoM)</label>
            <select name="unit_id"
              class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-3.5 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer shadow-sm">
              <option value="" disabled selected>Pilih Satuan</option>
              @foreach($units as $unit)
              <option value="{{ $unit->id }}" {{ old('unit_id')==$unit->id ? 'selected' : '' }}>
                {{ $unit->code }} ({{ $unit->name }})
              </option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      {{-- Section 3: Inventory Type --}}
      <div class="space-y-4">
        <label class="text-[11px] font-bold uppercase tracking-[0.1em] text-slate-500 ml-1">Tipe Barang</label>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          @php
          $types = [
          'raw_material' => ['label' => 'Raw Material', 'icon' => 'box', 'desc' => 'Bahan Baku'],
          'semi_finished' => ['label' => 'Semi Finished', 'icon' => 'component', 'desc' => 'Barang Setengah Jadi'],
          'finished' => ['label' => 'Finished Goods', 'icon' => 'check-square', 'desc' => 'Produk Jadi']
          ];
          @endphp

          @foreach($types as $value => $data)
          <label
            class="relative flex flex-col items-start p-5 border-2 border-slate-100 rounded-[1.5rem] cursor-pointer hover:border-indigo-200 hover:bg-indigo-50/10 transition-all group">
            <input type="radio" name="type" value="{{ $value }}" class="absolute opacity-0 peer" {{ (old('type')
              ?? 'raw_material' )==$value ? 'checked' : '' }}>

            {{-- Background indicator --}}
            <div
              class="absolute inset-0 border-2 border-transparent peer-checked:border-slate-900 peer-checked:bg-white peer-checked:shadow-xl peer-checked:shadow-slate-200/50 rounded-[1.5rem] transition-all">
            </div>

            <div class="relative z-10 w-full">
              <div class="flex justify-between items-start mb-3">
                <div
                  class="w-10 h-10 rounded-xl bg-slate-50 group-hover:bg-white flex items-center justify-center peer-checked:bg-slate-900 transition-colors">
                  <i data-lucide="{{ $data['icon'] }}"
                    class="w-5 h-5 text-slate-400 peer-checked:text-white transition-colors"></i>
                </div>
                <div
                  class="w-5 h-5 rounded-full border-2 border-slate-100 flex items-center justify-center peer-checked:border-slate-900 peer-checked:bg-slate-900 transition-all">
                  <i data-lucide="check"
                    class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                </div>
              </div>
              <p class="text-xs font-extrabold text-slate-900 uppercase tracking-widest">{{ $data['label'] }}</p>
              <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">{{ $data['desc'] }}</p>
            </div>
          </label>
          @endforeach
        </div>
      </div>

      {{-- Section 4: Status Toggle --}}
      <div
        class="p-6 bg-slate-50 rounded-[2rem] border border-slate-100 flex items-center justify-between transition-all">
        <div class="flex items-center gap-4">
          <div
            class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center border border-slate-200 shadow-sm">
            <i data-lucide="zap" class="w-6 h-6 text-emerald-500"></i>
          </div>
          <div>
            <p class="font-extrabold text-slate-900 text-sm tracking-tight">Aktifkan Langsung?</p>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-wider">Produk akan langsung tersedia untuk
              transaksi.</p>
          </div>
        </div>

        <label class="relative inline-flex items-center cursor-pointer scale-110">
          <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
          <div
            class="w-12 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900">
          </div>
        </label>
      </div>

      {{-- Form Actions --}}
      <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-50">
        <a href="{{ route('products.index') }}"
          class="px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
          Batal
        </a>
        <button type="submit"
          class="px-12 py-4 bg-slate-900 text-white text-sm font-bold rounded-2xl hover:bg-slate-800 shadow-xl shadow-slate-200 transition-all flex items-center gap-3 active:scale-95">
          <i data-lucide="plus-circle" class="w-5 h-5"></i>
          Daftarkan Produk
        </button>
      </div>
    </form>
  </div>
</div>
@endsection