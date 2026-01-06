@extends('layouts.app')

@section('title', 'Modify Partner | ERP Tekstil')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Breadcrumb & Header --}}
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('customers.index') }}" 
               class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-amber-600 flex items-center justify-center transition-all shadow-sm group">
                <i data-lucide="chevron-left" class="w-6 h-6 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <p class="text-[10px] font-black text-amber-600 uppercase tracking-[0.3em] mb-1">Database Update</p>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Modify <span class="text-slate-400">Partner</span></h1>
            </div>
        </div>
        <div class="hidden md:block">
            <span class="px-4 py-2 bg-slate-100 rounded-lg text-[9px] font-black text-slate-400 uppercase tracking-widest">UID: {{ $customer->id }}</span>
        </div>
    </div>

    <form method="POST" action="{{ route('customers.update', $customer) }}" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')
        
        {{-- Side Context Card --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-amber-500 rounded-[2.5rem] p-8 text-slate-900 relative overflow-hidden shadow-2xl shadow-amber-100">
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-amber-900 mb-4 opacity-50">Modification Mode</h3>
                    <p class="text-xl font-black leading-tight italic uppercase tracking-tighter">
                        Updating records for <span class="text-white">{{ $customer->name }}</span>
                    </p>
                    <div class="mt-6 pt-6 border-t border-amber-400/30">
                        <p class="text-[10px] font-bold leading-relaxed text-amber-900/60 uppercase tracking-widest">
                            Terakhir diperbarui:<br>
                            {{ $customer->updated_at->format('d M Y | H:i') }}
                        </p>
                    </div>
                </div>
                <div class="absolute -bottom-6 -right-6 opacity-20">
                    <i data-lucide="edit-3" class="w-32 h-32"></i>
                </div>
            </div>
        </div>

        {{-- Main Form Card --}}
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-100 p-8 md:p-12">
                <div class="grid grid-cols-1 gap-10">
                    
                    {{-- Customer Name --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-amber-600 transition-colors">
                            <i data-lucide="building" class="w-3 h-3"></i> Full Name / Entity
                        </label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" required 
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-amber-500 focus:ring-0 font-black text-slate-800 transition-all">
                        @error('name') <p class="mt-2 text-[10px] text-rose-500 font-black uppercase tracking-widest ml-4">{{ $message }}</p> @enderror
                    </div>

                    {{-- Contact Number --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-amber-600 transition-colors">
                            <i data-lucide="phone" class="w-3 h-3"></i> WhatsApp / Mobile
                        </label>
                        <input type="text" name="contact" value="{{ old('contact', $customer->contact) }}"
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-amber-500 focus:ring-0 font-mono font-black text-slate-800 tracking-tighter transition-all">
                        @error('contact') <p class="mt-2 text-[10px] text-rose-500 font-black uppercase tracking-widest ml-4">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-amber-600 transition-colors">
                            <i data-lucide="map-pin" class="w-3 h-3"></i> Logistics Address
                        </label>
                        <textarea name="address" rows="5" 
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[2rem] focus:bg-white focus:border-amber-500 focus:ring-0 font-bold text-slate-700 leading-relaxed transition-all italic">{{ old('address', $customer->address) }}</textarea>
                        @error('address') <p class="mt-2 text-[10px] text-rose-500 font-black uppercase tracking-widest ml-4">{{ $message }}</p> @enderror
                    </div>

                </div>

                <div class="mt-12 flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="group flex-1 py-6 bg-slate-900 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-amber-600 shadow-2xl hover:shadow-amber-200 transition-all flex items-center justify-center gap-4 active:scale-95">
                        <i data-lucide="refresh-cw" class="w-4 h-4 text-amber-400 group-hover:rotate-180 transition-transform duration-700"></i>
                        Update Records
                    </button>
                    <a href="{{ route('customers.index') }}" class="py-6 px-10 bg-white border border-slate-100 text-slate-400 rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-slate-50 transition-all text-center">
                        Discard
                    </a>
                </div>
            </div>
            
            <p class="text-center text-[9px] font-black text-slate-300 uppercase tracking-[0.4em] italic">Authorized Personnel Access Only</p>
        </div>
    </form>
</div>
@endsection