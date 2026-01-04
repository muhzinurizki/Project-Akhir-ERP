@extends('layouts.app')

@section('title', 'Tambah Gudang')
@section('page-title', 'Inventory Management')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
  {{-- Breadcrumb --}}
  <div class="mb-8">
    <a href="{{ route('warehouses.index') }}"
      class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all group">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar Gudang
    </a>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Form --}}
    <div class="px-10 py-10 border-b border-slate-50 bg-slate-900 text-white relative overflow-hidden">
      <div class="relative z-10">
        <h2 class="text-2xl font-extrabold tracking-tight">Registrasi Gudang Baru</h2>
        <p class="text-slate-400 text-sm mt-1 font-medium">Tentukan titik penyimpanan baru untuk optimalisasi logistik.
        </p>
      </div>
      {{-- Background Decoration --}}
      <i data-lucide="warehouse" class="w-32 h-32 text-white opacity-5 absolute -right-6 -bottom-6 rotate-12"></i>
    </div>

    <form method="POST" action="{{ route('warehouses.store') }}" class="p-10 space-y-10">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        {{-- Bagian Kiri: Kode & Nama --}}
        <div class="space-y-6">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">01. Identitas Gudang</h3>
            <div class="h-px flex-1 bg-slate-100"></div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Kode Gudang</label>
            <div class="relative">
              <input name="code" placeholder="Contoh: WH-BGR-01" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              <i data-lucide="hash" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Nama Gudang</label>
            <div class="relative">
              <input name="name" placeholder="Nama area atau fungsi" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              <i data-lucide="tag" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>
        </div>

        {{-- Bagian Kanan: Alamat & Status --}}
        <div class="space-y-6">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">02. Lokasi & Status</h3>
            <div class="h-px flex-1 bg-slate-100"></div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Alamat Fisik</label>
            <textarea name="address" rows="3" placeholder="Alamat lengkap lokasi gudang..."
              class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm"></textarea>
          </div>

          <div class="pt-4">
            <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                  <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-500"></i>
                </div>
                <span class="text-xs font-bold text-slate-700 uppercase tracking-tight">Status Operasional Aktif</span>
              </div>
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
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
          Batalkan
        </a>
        <button type="submit"
          class="px-12 py-4 bg-indigo-600 text-white text-sm font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center gap-3 active:scale-95">
          <i data-lucide="save" class="w-5 h-5"></i>
          Simpan Lokasi
        </button>
      </div>
    </form>
  </div>
</div>
@endsection