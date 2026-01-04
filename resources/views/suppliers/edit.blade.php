@extends('layouts.app')

@section('title', 'Edit Supplier | ERP Tekstil')
@section('page-title', 'Purchasing')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    {{-- Navigation --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('suppliers.index') }}"
            class="group flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-[0.2em]">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </div>
            Kembali ke Daftar Vendor
        </a>

        <div class="flex items-center gap-3 self-end sm:self-auto">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Saat Ini:</span>
            @if($supplier->is_active)
            <span class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black border border-emerald-100 flex items-center gap-2 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> AKTIF / VALID
            </span>
            @else
            <span class="px-4 py-1.5 rounded-full bg-slate-100 text-slate-400 text-[10px] font-black border border-slate-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-slate-300"></span> NON-AKTIF
            </span>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        {{-- Header Form --}}
        <div class="px-12 py-10 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center relative overflow-hidden group">
            <div class="relative z-10">
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Perbarui Data Supplier</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Mengubah detail untuk mitra: <span class="text-indigo-600 font-black tracking-tight">{{ strtoupper($supplier->name) }}</span></p>
            </div>
            <div class="w-20 h-20 rounded-[2rem] bg-slate-900 flex items-center justify-center shadow-2xl shadow-slate-300 relative z-10 rotate-3 group-hover:rotate-0 transition-transform duration-500">
                <i data-lucide="file-edit" class="w-10 h-10 text-white"></i>
            </div>
            {{-- Decorative pattern --}}
            <div class="absolute top-0 right-0 w-32 h-full bg-indigo-600/5 -skew-x-12 translate-x-10"></div>
        </div>

        <form method="POST" action="{{ route('suppliers.update', $supplier) }}" class="p-12 space-y-12">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                {{-- Kiri: Informasi Utama --}}
                <div class="lg:col-span-7 space-y-10">
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span class="flex-none text-[11px] font-black text-indigo-600 uppercase tracking-[0.3em]">01. Informasi Perusahaan</span>
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Kode Vendor (Read-Only)</label>
                                <div class="relative">
                                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                                    <input value="{{ $supplier->code }}" readonly
                                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-mono font-black text-slate-400 cursor-not-allowed italic">
                                </div>
                                <p class="text-[9px] text-slate-300 font-bold mt-1.5 ml-1 italic">*Kode unik tidak dapat diubah setelah registrasi.</p>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Vendor</label>
                                <div class="relative group">
                                    <i data-lucide="briefcase" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input name="name" value="{{ old('name', $supplier->name) }}"
                                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner uppercase tracking-tight">
                                </div>
                                @error('name') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Alamat Kantor / Domisili</label>
                            <div class="relative group">
                                <i data-lucide="map-pin" class="absolute left-4 top-5 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                <textarea name="address" rows="4"
                                    class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner">{{ old('address', $supplier->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Detail Kontak & Status --}}
                <div class="lg:col-span-5">
                    <div class="bg-slate-50 rounded-[2.5rem] p-10 space-y-8 border border-slate-100 shadow-inner group/card hover:bg-white transition-all duration-500">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center shadow-sm group-hover/card:bg-indigo-600 group-hover/card:text-white transition-all duration-500">
                                <i data-lucide="contact" class="w-6 h-6"></i>
                            </div>
                            <h3 class="text-xs font-black text-slate-900 uppercase tracking-[0.2em]">Person in Charge</h3>
                        </div>

                        <div class="space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 ml-1 uppercase tracking-widest">Nama PIC</label>
                                <input name="contact_person" value="{{ old('contact_person', $supplier->contact_person) }}"
                                    class="w-full px-5 py-4 bg-white border border-slate-100 rounded-2xl text-sm font-black text-slate-900 focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-sm uppercase tracking-tight">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 ml-1 uppercase tracking-widest">No. WhatsApp</label>
                                <div class="relative">
                                    <input name="phone" value="{{ old('phone', $supplier->phone) }}"
                                        class="w-full px-5 py-4 bg-white border border-slate-100 rounded-2xl text-sm font-black text-slate-900 focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-sm">
                                    <i data-lucide="phone" class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-200"></i>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 ml-1 uppercase tracking-widest">Email Bisnis</label>
                                <div class="relative">
                                    <input name="email" type="email" value="{{ old('email', $supplier->email) }}"
                                        class="w-full px-5 py-4 bg-white border border-slate-100 rounded-2xl text-sm font-black text-slate-900 focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-sm">
                                    <i data-lucide="mail" class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-200"></i>
                                </div>
                            </div>
                        </div>

                        <div class="pt-8 border-t border-slate-100">
                            <div class="flex items-center justify-between p-5 bg-white rounded-2xl border border-slate-100 group-hover/card:border-indigo-100 transition-colors">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-slate-900 uppercase tracking-tight">Status Operasional</span>
                                    <span class="text-[9px] text-slate-400 font-bold uppercase mt-0.5">Aktifkan untuk transaksi PO</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer scale-110">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active', $supplier->is_active))>
                                    <div class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900 shadow-inner"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-8 pt-10 border-t border-slate-50">
                <a href="{{ route('suppliers.index') }}"
                    class="text-[11px] font-black text-slate-400 hover:text-rose-600 transition-all uppercase tracking-[0.2em]">
                    Batalkan Perubahan
                </a>
                <button type="submit"
                    class="px-14 py-5 bg-indigo-600 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-700 shadow-2xl shadow-indigo-200 transition-all flex items-center gap-4 active:scale-95 group">
                    <i data-lucide="refresh-cw" class="w-5 h-5 group-hover:rotate-180 transition-transform duration-700"></i>
                    Update Data Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection