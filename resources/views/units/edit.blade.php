@extends('layouts.app')

@section('title', 'Edit Satuan | ERP Tekstil')

@section('content')
<div class="max-w-3xl mx-auto pb-20">
    <div class="mb-8">
        <a href="{{ route('units.index') }}"
            class="group flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-widest">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </div>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        <div class="px-12 py-10 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Update Satuan</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Mengubah spesifikasi unit #{{ $unit->code }}</p>
            </div>
            <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center shadow-xl shadow-slate-200">
                <i data-lucide="scale" class="text-white w-8 h-8"></i>
            </div>
        </div>

        <form method="POST" action="{{ route('units.update', $unit) }}" class="p-12 space-y-10">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="space-y-3">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Kode (UoM)</label>
                    <input type="text" name="code" value="{{ old('code', $unit->code) }}" required
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all uppercase">
                </div>

                <div class="md:col-span-2 space-y-3">
                    <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $unit->name) }}" required
                        class="w-full px-6 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all">
                </div>
            </div>

            <div class="flex items-center justify-end gap-8 pt-6">
                <a href="{{ route('units.index') }}" class="text-[11px] font-black text-slate-400 hover:text-rose-600 uppercase tracking-widest transition-colors">Batalkan</a>
                <button type="submit"
                    class="px-12 py-5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-emerald-600 shadow-2xl shadow-emerald-200 transition-all flex items-center gap-4 active:scale-95">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection