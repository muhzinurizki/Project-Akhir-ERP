@extends('layouts.app')

@section('title', 'Tambah Supplier | ERP Tekstil')
@section('page-title', 'Purchasing')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    {{-- Navigation --}}
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('suppliers.index') }}"
            class="group flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-[0.2em]">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </div>
            Kembali ke Daftar Vendor
        </a>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        {{-- Header Form --}}
        <div class="px-12 py-10 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Registrasi Supplier Baru</h2>
                <p class="text-sm text-slate-500 font-medium mt-1 italic">Pastikan data legalitas dan kontak supplier valid untuk keperluan PO & Invoice.</p>
            </div>
            <div class="hidden md:flex w-20 h-20 rounded-[2rem] bg-indigo-600 items-center justify-center shadow-2xl shadow-indigo-200 rotate-3 group">
                <i data-lucide="building-2" class="w-10 h-10 text-white group-hover:scale-110 transition-transform"></i>
            </div>
        </div>

        <form method="POST" action="{{ route('suppliers.store') }}" class="p-12 space-y-12">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                {{-- Kiri: Informasi Legal & Identitas --}}
                <div class="lg:col-span-7 space-y-10">
                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span class="flex-none text-[11px] font-black text-indigo-600 uppercase tracking-[0.3em]">01. Identitas Legal</span>
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Kode Vendor</label>
                                <div class="relative group">
                                    <i data-lucide="hash" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input name="code" value="{{ old('code') }}" placeholder="SUPP-001"
                                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border @error('code') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner uppercase">
                                </div>
                                @error('code') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Perusahaan</label>
                                <div class="relative group">
                                    <i data-lucide="briefcase" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                    <input name="name" value="{{ old('name') }}" placeholder="PT. Maju Jaya"
                                        class="w-full pl-11 pr-4 py-4 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner uppercase tracking-tight">
                                </div>
                                @error('name') <p class="text-[10px] text-rose-500 font-bold mt-1 ml-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Alamat Kantor / NPWP</label>
                            <div class="relative group">
                                <i data-lucide="map-pin" class="absolute left-4 top-5 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                                <textarea name="address" rows="3" placeholder="Jl. Kawasan Industri No. 12..."
                                    class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-8">
                        <div class="flex items-center gap-4">
                            <span class="flex-none text-[11px] font-black text-indigo-600 uppercase tracking-[0.3em]">02. Financial Setting</span>
                            <div class="h-px flex-1 bg-slate-100"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Term of Payment</label>
                                <div class="relative group">
                                    <i data-lucide="clock" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none z-10"></i>
                                    <select name="term_of_payment"
                                        class="w-full pl-11 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer uppercase shadow-inner">
                                        <option value="COD">Cash on Delivery</option>
                                        <option value="NET7">Net 7 Days</option>
                                        <option value="NET30">Net 30 Days</option>
                                        <option value="NET60">Net 60 Days</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none"></i>
                                </div>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 ml-1">Mata Uang</label>
                                <div class="relative group">
                                    <i data-lucide="banknote" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none z-10"></i>
                                    <select name="currency"
                                        class="w-full pl-11 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer uppercase shadow-inner">
                                        <option value="IDR">IDR - Rupiah</option>
                                        <option value="USD">USD - US Dollar</option>
                                    </select>
                                    <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kanan: Person in Charge --}}
                <div class="lg:col-span-5">
                    <div class="bg-slate-900 rounded-[2.5rem] p-10 space-y-8 shadow-2xl shadow-slate-200 relative overflow-hidden group/card">
                        {{-- Decorative background --}}
                        <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>

                        <div class="flex items-center gap-4 relative z-10">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center border border-white/10 shadow-inner group-hover/card:scale-110 transition-transform">
                                <i data-lucide="user-check" class="w-6 h-6 text-indigo-400"></i>
                            </div>
                            <h3 class="text-xs font-black text-white uppercase tracking-[0.2em]">Contact Person</h3>
                        </div>

                        <div class="space-y-6 relative z-10">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Nama PIC</label>
                                <input name="contact_person" value="{{ old('contact_person') }}" placeholder="Nama Lengkap"
                                    class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-sm font-black text-white placeholder:text-slate-600 focus:bg-white/10 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-inner">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">No. WhatsApp</label>
                                <input name="phone" value="{{ old('phone') }}" placeholder="0812xxxx"
                                    class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-sm font-black text-white placeholder:text-slate-600 focus:bg-white/10 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-inner">
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1">Email Bisnis</label>
                                <input name="email" type="email" value="{{ old('email') }}" placeholder="vendor@email.com"
                                    class="w-full px-5 py-4 bg-white/5 border border-white/10 rounded-2xl text-sm font-black text-white placeholder:text-slate-600 focus:bg-white/10 focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all shadow-inner">
                            </div>
                        </div>

                        <div class="pt-8 border-t border-white/10 relative z-10">
                            <label class="relative inline-flex items-center cursor-pointer group/toggle">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-lg"></div>
                                <span class="ml-4 text-[10px] font-black text-slate-400 uppercase tracking-widest group-hover/toggle:text-white transition-colors">Set as Active Partner</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end gap-8 pt-10 border-t border-slate-50">
                <a href="{{ route('suppliers.index') }}"
                    class="text-[11px] font-black text-slate-400 hover:text-rose-600 transition-all uppercase tracking-[0.2em]">Batalkan</a>
                <button type="submit"
                    class="px-14 py-5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-600 shadow-2xl shadow-indigo-200 transition-all flex items-center gap-4 active:scale-95 group">
                    <i data-lucide="save" class="w-5 h-5 group-hover:scale-125 transition-transform"></i>
                    Daftarkan Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection