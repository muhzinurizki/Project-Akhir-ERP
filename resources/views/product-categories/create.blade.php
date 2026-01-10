@extends('layouts.app')

@section('title', 'Tambah Kategori | ERP Tekstil')

@section('content')
<div class="max-w-3xl mx-auto pb-20">
    {{-- Navigation --}}
    <div class="mb-8">
        <a href="{{ route('product-categories.index') }}"
            class="group flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-widest">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </div>
            Kembali ke Daftar Kategori
        </a>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        <div class="px-12 py-10 border-b border-slate-50 bg-slate-50/30">
            <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Kategori Baru</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Definisikan kelompok besar untuk klasifikasi inventaris Anda.</p>
        </div>

        <form method="POST" action="{{ route('product-categories.store') }}" class="p-12 space-y-10">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                {{-- Kode Kategori --}}
                <div class="space-y-3">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Kode Kategori</label>
                    <input type="text" name="code" value="{{ old('code') }}" placeholder="Contoh: RAW" required
                        class="w-full px-6 py-4 bg-slate-50 border @error('code') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all uppercase">
                    @error('code') <p class="text-[10px] text-rose-500 font-bold uppercase italic tracking-tighter">{{ $message }}</p> @enderror
                </div>

                {{-- Nama Kategori --}}
                <div class="md:col-span-2 space-y-3">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Raw Material" required
                        class="w-full px-6 py-4 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all">
                    @error('name') <p class="text-[10px] text-rose-500 font-bold uppercase italic tracking-tighter">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="space-y-3">
                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Deskripsi Singkat</label>
                <textarea name="description" rows="4" 
                    class="w-full p-6 bg-slate-50 border border-slate-100 rounded-[2rem] text-sm font-medium focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner">{{ old('description') }}</textarea>
            </div>

            {{-- Submit --}}
            <div class="flex items-center justify-end gap-8 pt-6">
                <button type="submit"
                    class="px-12 py-5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-600 shadow-2xl shadow-indigo-200 transition-all flex items-center gap-4 active:scale-95 group">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection