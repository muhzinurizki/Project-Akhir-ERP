@extends('layouts.app')

@section('title', 'Edit Gudang | ERP Tekstil')
@section('page-title', 'Inventory Management')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- Navigation & Status Bar --}}
    <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <a href="{{ route('warehouses.index') }}"
            class="group flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-[0.2em]">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4 transition-transform group-hover:-translate-x-1"></i>
            </div>
            Kembali ke Daftar Gudang
        </a>

        <div class="flex items-center gap-4 bg-white px-5 py-2 rounded-2xl border border-slate-100 shadow-sm">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Kondisi Saat Ini:</span>
            @if($warehouse->is_active)
            <span class="flex items-center gap-2 text-emerald-600 text-[10px] font-black uppercase">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Operasional
            </span>
            @else
            <span class="flex items-center gap-2 text-slate-400 text-[10px] font-black uppercase italic">
                <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                Non-Aktif
            </span>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        {{-- Header Form --}}
        <div class="px-12 py-10 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center relative overflow-hidden group">
            <div class="relative z-10">
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Perbarui Detail Gudang</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Mengedit lokasi: <span class="text-indigo-600 font-black tracking-tight uppercase">{{ $warehouse->name }}</span></p>
            </div>
            <div class="w-20 h-20 rounded-[2rem] bg-slate-900 flex items-center justify-center shadow-2xl shadow-slate-300 relative z-10 group-hover:rotate-6 transition-transform duration-500">
                <i data-lucide="edit-3" class="w-10 h-10 text-white"></i>
            </div>
            <i data-lucide="warehouse" class="w-48 h-48 text-indigo-600/5 absolute -right-10 -bottom-10 rotate-12 group-hover:rotate-0 transition-all duration-1000"></i>
        </div>

        <form method="POST" action="{{ route('warehouses.update', $warehouse) }}" class="p-12 space-y-12">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- Bagian Kiri: Identitas --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <span class="flex-none text-[11px] font-black text-indigo-600 uppercase tracking-[0.3em]">01. Data Identitas</span>
                        <div class="h-px flex-1 bg-slate-100"></div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Kode Gudang (Read-Only)</label>
                        <div class="relative group">
                            <input value="{{ $warehouse->code }}" readonly
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-mono font-black text-slate-400 cursor-not-allowed italic shadow-inner">
                            <i data-lucide="lock" class="w-4 h-4 text-slate-300 absolute left-4 top-1/2 -translate-y-1/2"></i>
                        </div>
                        <p class="text-[9px] text-slate-400 mt-2 ml-1 leading-relaxed font-bold italic opacity-70">* Kode tidak dapat diubah untuk menjaga integritas riwayat stok.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Gudang</label>
                        <div class="relative group">
                            <input name="name" value="{{ old('name', $warehouse->name) }}" required
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner uppercase tracking-tight">
                            <i data-lucide="tag" class="w-4 h-4 text-slate-300 absolute left-4 top-1/2 -translate-y-1/2 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                        @error('name') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Bagian Kanan: Lokasi & Status --}}
                <div class="space-y-8">
                    <div class="flex items-center gap-4">
                        <span class="flex-none text-[11px] font-black text-indigo-600 uppercase tracking-[0.3em]">02. Alamat & Akses</span>
                        <div class="h-px flex-1 bg-slate-100"></div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Alamat Fisik</label>
                        <div class="relative group">
                            <textarea name="address" rows="4"
                                class="w-full pl-12 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner leading-relaxed">{{ old('address', $warehouse->address) }}</textarea>
                            <i data-lucide="map-pin" class="w-4 h-4 text-slate-300 absolute left-4 top-5 group-focus-within:text-indigo-600 transition-colors"></i>
                        </div>
                    </div>

                    <div class="pt-2">
                        <div class="flex items-center justify-between p-5 bg-white rounded-[1.5rem] border border-slate-100 shadow-sm group/status hover:border-indigo-100 transition-all duration-500">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover/status:bg-indigo-600 group-hover/status:text-white transition-all">
                                    <i data-lucide="activity" class="w-5 h-5"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-tight">Izin Operasional</span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase">Status aktif saat ini</span>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer scale-110">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active', $warehouse->is_active))>
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
                    Batalkan Perubahan
                </a>
                <button type="submit"
                    class="px-14 py-5 bg-indigo-600 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-700 shadow-2xl shadow-indigo-100 transition-all flex items-center gap-4 active:scale-95 group">
                    <i data-lucide="refresh-cw" class="w-5 h-5 group-hover:rotate-180 transition-transform duration-700"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection