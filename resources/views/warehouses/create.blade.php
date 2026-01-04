@extends('layouts.app')

@section('title', 'Tambah Gudang | ERP Tekstil')
@section('page-title', 'Inventory Management')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- Breadcrumb --}}
    <div class="mb-8">
        <a href="{{ route('warehouses.index') }}"
            class="inline-flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all group uppercase tracking-[0.2em]">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
            </div>
            Kembali ke Daftar Gudang
        </a>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        {{-- Header Form --}}
        <div class="px-12 py-12 border-b border-slate-50 bg-slate-900 text-white relative overflow-hidden group">
            <div class="relative z-10">
                <h2 class="text-3xl font-black tracking-tighter uppercase italic">Registrasi Gudang Baru</h2>
                <p class="text-slate-400 text-sm mt-2 font-medium italic">Tentukan titik penyimpanan baru untuk optimalisasi logistik aliran barang.</p>
            </div>
            {{-- Background Decoration --}}
            <i data-lucide="warehouse" class="w-48 h-48 text-white opacity-[0.03] absolute -right-8 -bottom-8 rotate-12 group-hover:rotate-0 transition-transform duration-1000"></i>
            <div class="absolute top-0 right-0 w-32 h-full bg-white/5 skew-x-[-20deg] translate-x-16"></div>
        </div>

        <form method="POST" action="{{ route('warehouses.store') }}" class="p-12 space-y-12">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- Bagian Kiri: Identitas --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <span class="flex-none text-[11px] font-black text-indigo-600 uppercase tracking-[0.3em]">01. Identitas Gudang</span>
                        <div class="h-px flex-1 bg-slate-100"></div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Kode Gudang</label>
                        <div class="relative group">
                            <input name="code" value="{{ old('code') }}" placeholder="Contoh: WH-BGR-01" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border @error('code') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner uppercase">
                            <i data-lucide="hash" class="w-4 h-4 text-slate-300 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        @error('code') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                        <p class="text-[9px] text-slate-400 font-medium ml-1 mt-1">*Gunakan format unik untuk identifikasi sistem.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Gudang</label>
                        <div class="relative group">
                            <input name="name" value="{{ old('name') }}" placeholder="Contoh: Gudang Bahan Baku Utama" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner uppercase tracking-tight">
                            <i data-lucide="tag" class="w-4 h-4 text-slate-300 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        @error('name') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Bagian Kanan: Lokasi --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <span class="flex-none text-[11px] font-black text-indigo-600 uppercase tracking-[0.3em]">02. Lokasi & Status</span>
                        <div class="h-px flex-1 bg-slate-100"></div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Alamat Fisik</label>
                        <div class="relative group">
                            <textarea name="address" rows="4" placeholder="Alamat lengkap lokasi gudang..."
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner leading-relaxed">{{ old('address') }}</textarea>
                            <i data-lucide="map-pin" class="w-4 h-4 text-slate-300 absolute left-4 top-5 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="flex items-center justify-between p-5 bg-slate-50 rounded-[1.5rem] border border-slate-100 shadow-inner group/status hover:bg-white transition-all duration-500">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm text-emerald-500 group-hover/status:bg-emerald-500 group-hover/status:text-white transition-all">
                                    <i data-lucide="shield-check" class="w-5 h-5"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-tight">Status Aktif</span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase">Siap menerima stok barang</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer scale-110">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900 shadow-inner"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-8 pt-10 border-t border-slate-50">
                <a href="{{ route('warehouses.index') }}"
                    class="text-[11px] font-black text-slate-400 hover:text-rose-600 transition-all uppercase tracking-[0.2em]">
                    Batalkan Registrasi
                </a>
                <button type="submit"
                    class="px-14 py-5 bg-indigo-600 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-700 shadow-2xl shadow-indigo-100 transition-all flex items-center gap-4 active:scale-95 group">
                    <i data-lucide="save" class="w-5 h-5 group-hover:scale-125 transition-transform"></i>
                    Daftarkan Gudang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection