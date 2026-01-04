@extends('layouts.app')

@section('title', 'Edit Supplier')
@section('page-title', 'Purchasing')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
  {{-- Navigation --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('suppliers.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar Vendor
    </a>

    <div class="flex items-center gap-3">
      <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Saat Ini:</span>
      @if($supplier->is_active)
      <span
        class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100 flex items-center gap-1.5">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> AKTIF
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
    <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Perbarui Data Supplier</h2>
        <p class="text-sm text-slate-500 font-medium mt-1">Mengubah detail untuk mitra: <span
            class="text-indigo-600 font-bold">{{ $supplier->name }}</span></p>
      </div>
      <div class="w-16 h-16 rounded-2xl bg-slate-900 flex items-center justify-center shadow-lg shadow-slate-200">
        <i data-lucide="edit-3" class="w-8 h-8 text-white"></i>
      </div>
    </div>

    <form method="POST" action="{{ route('suppliers.update', $supplier) }}" class="p-10 space-y-10">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- Kiri: Informasi Utama --}}
        <div class="lg:col-span-7 space-y-8">
          <div class="space-y-6">
            <div class="flex items-center gap-3">
              <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">01. Informasi Perusahaan
              </h3>
              <div class="h-px flex-1 bg-slate-100"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Kode Vendor
                  (Read-Only)</label>
                <input name="code" value="{{ old('code', $supplier->code) }}" readonly
                  class="w-full px-4 py-3.5 bg-slate-100 border border-slate-200 rounded-2xl text-sm font-mono font-bold text-slate-500 cursor-not-allowed">
              </div>
              <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Nama Vendor</label>
                <input name="name" value="{{ old('name', $supplier->name) }}"
                  class="w-full px-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              </div>
            </div>

            <div class="space-y-2">
              <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Alamat Kantor /
                Domisili</label>
              <textarea name="address" rows="3"
                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">{{ old('address', $supplier->address) }}</textarea>
            </div>
          </div>
        </div>

        {{-- Kanan: Detail Kontak & Status --}}
        <div class="lg:col-span-5 space-y-8">
          <div class="bg-slate-50 rounded-[2rem] p-8 space-y-6 border border-slate-100">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                <i data-lucide="contact" class="w-4 h-4 text-indigo-600"></i>
              </div>
              <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-widest">Person in Charge</h3>
            </div>

            <div class="space-y-4">
              <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-slate-400 ml-1 uppercase">Nama PIC</label>
                <input name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}"
                  class="w-full px-4 py-3 border-transparent rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-600 outline-none transition-all shadow-sm">
              </div>
              <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-slate-400 ml-1 uppercase">No. WhatsApp</label>
                <input name="phone" value="{{ old('phone', $supplier->phone) }}"
                  class="w-full px-4 py-3 border-transparent rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-600 outline-none transition-all shadow-sm">
              </div>
              <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-slate-400 ml-1 uppercase">Email Bisnis</label>
                <input name="email" type="email" value="{{ old('email', $supplier->email) }}"
                  class="w-full px-4 py-3 border-transparent rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-600 outline-none transition-all shadow-sm">
              </div>
            </div>

            <div class="pt-6 border-t border-slate-200/50">
              <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-slate-100">
                <span class="text-xs font-bold text-slate-700 uppercase tracking-tight">Status Aktif</span>
                <label class="relative inline-flex items-center cursor-pointer">
                  <input type="hidden" name="is_active" value="0">
                  <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active',
                    $supplier->is_active))>
                  <div
                    class="w-10 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-slate-900">
                  </div>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center justify-end gap-4 pt-10 border-t border-slate-50">
        <a href="{{ route('suppliers.index') }}"
          class="px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
          Batalkan Perubahan
        </a>
        <button type="submit"
          class="px-12 py-4 bg-indigo-600 text-white text-sm font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center gap-3 active:scale-95">
          <i data-lucide="refresh-cw" class="w-5 h-5"></i>
          Update Data Supplier
        </button>
      </div>
    </form>
  </div>
</div>
@endsection