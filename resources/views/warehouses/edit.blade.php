@extends('layouts.app')

@section('title', 'Edit Gudang')
@section('page-title', 'Inventory Management')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
  {{-- Navigation --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('warehouses.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar Gudang
    </a>

    {{-- Status Badge --}}
    <div class="flex items-center gap-3">
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kondisi Saat Ini:</span>
      @if($warehouse->is_active)
      <span
        class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100 flex items-center gap-1.5">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> OPERASIONAL
      </span>
      @else
      <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-400 text-[10px] font-bold border border-slate-200">
        NON-AKTIF
      </span>
      @endif
    </div>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Form --}}
    <div
      class="px-10 py-10 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center relative overflow-hidden">
      <div class="relative z-10">
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Perbarui Detail Gudang</h2>
        <p class="text-sm text-slate-500 font-medium mt-1">Mengedit lokasi: <span class="text-indigo-600 font-bold">{{
            $warehouse->name }}</span></p>
      </div>
      <div
        class="w-16 h-16 rounded-2xl bg-slate-900 flex items-center justify-center shadow-lg shadow-slate-200 relative z-10">
        <i data-lucide="edit-3" class="w-8 h-8 text-white"></i>
      </div>
      <i data-lucide="warehouse"
        class="w-40 h-40 text-slate-200 opacity-20 absolute -right-10 -bottom-10 rotate-12"></i>
    </div>

    <form method="POST" action="{{ route('warehouses.update', $warehouse) }}" class="p-10 space-y-10">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        {{-- Bagian Kiri: Identitas --}}
        <div class="space-y-6">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">01. Data Identitas</h3>
            <div class="h-px flex-1 bg-slate-100"></div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Kode Gudang
              (Read-Only)</label>
            <div class="relative">
              <input name="code" value="{{ old('code', $warehouse->code) }}" readonly
                class="w-full pl-11 pr-4 py-3.5 bg-slate-100 border border-slate-200 rounded-2xl text-sm font-mono font-bold text-slate-500 cursor-not-allowed shadow-inner">
              <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
            <p class="text-[9px] text-slate-400 mt-1 ml-1 leading-relaxed italic">* Kode gudang tidak dapat diubah untuk
              menjaga integritas data stok.</p>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Nama Gudang</label>
            <div class="relative">
              <input name="name" value="{{ old('name', $warehouse->name) }}" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              <i data-lucide="tag" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>
        </div>

        {{-- Bagian Kanan: Lokasi & Status --}}
        <div class="space-y-6">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">02. Alamat & Akses</h3>
            <div class="h-px flex-1 bg-slate-100"></div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Alamat Fisik</label>
            <textarea name="address" rows="3"
              class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">{{ old('address', $warehouse->address) }}</textarea>
          </div>

          <div class="pt-4">
            <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-100 shadow-sm">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center">
                  <i data-lucide="activity" class="w-4 h-4 text-slate-600"></i>
                </div>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-tight">Status Aktif</span>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active',
                  $warehouse->is_active))>
                <div
                  class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900">
                </div>
              </label>
            </div>
          </div>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center justify-end gap-4 pt-10 border-t border-slate-50">
        <a href="{{ route('warehouses.index') }}"
          class="px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
          Batalkan Perubahan
        </a>
        <button type="submit"
          class="px-12 py-4 bg-indigo-600 text-white text-sm font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center gap-3 active:scale-95">
          <i data-lucide="refresh-cw" class="w-5 h-5"></i>
          Update Data Gudang
        </button>
      </div>
    </form>
  </div>
</div>
@endsection