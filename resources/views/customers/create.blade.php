@extends('layouts.app')

@section('title', 'Register Partner | ERP Tekstil')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Breadcrumb & Header --}}
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('customers.index') }}" 
               class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 flex items-center justify-center transition-all shadow-sm group">
                <i data-lucide="chevron-left" class="w-6 h-6 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-1">Customer Hub</p>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">New <span class="text-slate-400">Partner</span></h1>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('customers.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        
        {{-- Side Info --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10">
                    <h3 class="text-xs font-black uppercase tracking-widest text-indigo-400 mb-4">Quick Guide</h3>
                    <p class="text-[11px] leading-relaxed text-slate-400 font-bold italic uppercase tracking-tighter">
                        Pastikan data alamat pengiriman sudah akurat untuk kebutuhan sinkronisasi modul <span class="text-white">Delivery Order</span> di tahap selanjutnya.
                    </p>
                </div>
                <div class="absolute -bottom-6 -right-6 opacity-10">
                    <i data-lucide="contact-2" class="w-32 h-32"></i>
                </div>
            </div>
        </div>

        {{-- Main Form Card --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-100 p-8 md:p-12 relative">
                <div class="grid grid-cols-1 gap-10">
                    
                    {{-- Customer Name --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-indigo-600 transition-colors">
                            <i data-lucide="building" class="w-3 h-3"></i> Full Name / Entity
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" required 
                            placeholder="e.g. PT. Global Tekstil"
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-600 focus:ring-0 font-black text-slate-800 transition-all placeholder:text-slate-300">
                        @error('name') <p class="mt-2 text-[10px] text-rose-500 font-black uppercase tracking-widest ml-4">{{ $message }}</p> @enderror
                    </div>

                    {{-- Contact Number --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-indigo-600 transition-colors">
                            <i data-lucide="phone" class="w-3 h-3"></i> WhatsApp / Mobile
                        </label>
                        <input type="text" name="contact" value="{{ old('contact') }}"
                            placeholder="081234567xxx"
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-600 focus:ring-0 font-mono font-black text-slate-800 tracking-tighter transition-all placeholder:text-slate-300">
                        @error('contact') <p class="mt-2 text-[10px] text-rose-500 font-black uppercase tracking-widest ml-4">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-indigo-600 transition-colors">
                            <i data-lucide="map-pin" class="w-3 h-3"></i> Logistics Address
                        </label>
                        <textarea name="address" rows="5" 
                            placeholder="Jl. Raya Industri No. 45, Bandung..."
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[2rem] focus:bg-white focus:border-indigo-600 focus:ring-0 font-bold text-slate-700 leading-relaxed transition-all placeholder:text-slate-300 italic">{{ old('address') }}</textarea>
                        @error('address') <p class="mt-2 text-[10px] text-rose-500 font-black uppercase tracking-widest ml-4">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="mt-12">
                    <button type="submit" class="group w-full py-6 bg-slate-900 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-indigo-600 shadow-2xl hover:shadow-indigo-200 transition-all flex items-center justify-center gap-4 active:scale-95">
                        <i data-lucide="save" class="w-4 h-4 text-indigo-300 group-hover:rotate-12 transition-transform"></i>
                        Confirm Registration
                    </button>
                </div>
            </div>
            
            <p class="text-center text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic">Official Textile ERP Database System</p>
        </div>
    </form>
</div>
@endsection