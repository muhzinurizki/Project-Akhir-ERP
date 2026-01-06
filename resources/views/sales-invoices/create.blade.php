@extends('layouts.app')

@section('title', 'Generate Invoice | ERP Tekstil')

@section('content')
<div class="max-w-5xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Breadcrumb & Header --}}
    <div class="mb-12 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('sales-invoices.index') }}" 
               class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 flex items-center justify-center transition-all shadow-sm group">
                <i data-lucide="chevron-left" class="w-6 h-6 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-1">Financial Module</p>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">New <span class="text-slate-400">Invoice</span></h1>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('sales-invoices.store') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        
        {{-- Left Side: Main Form --}}
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.03)] border border-slate-100 p-8 md:p-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    
                    {{-- Customer Selection --}}
                    <div class="md:col-span-2 group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-indigo-600 transition-colors">
                            <i data-lucide="user-check" class="w-3 h-3"></i> Assign Customer
                        </label>
                        <select name="customer_id" required 
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-600 focus:ring-0 font-black text-slate-800 transition-all appearance-none cursor-pointer">
                            <option value="">-- SEARCH PARTNER --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Invoice Number --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-indigo-600 transition-colors">
                            <i data-lucide="hash" class="w-3 h-3"></i> Document ID
                        </label>
                        <input type="text" name="invoice_number" value="INV/SLS/{{ date('Ymd') }}/{{ rand(100,999) }}" required
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-600 focus:ring-0 font-mono font-black text-slate-800 tracking-widest transition-all">
                    </div>

                    {{-- Total Billing --}}
                    <div class="group text-right">
                        <label class="flex items-center justify-end gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 mr-1 group-focus-within:text-indigo-600 transition-colors">
                            Grand Total (IDR) <i data-lucide="banknote" class="w-3 h-3"></i>
                        </label>
                        <div class="relative">
                            <input type="number" name="total_amount" placeholder="0" required
                                class="w-full px-6 py-5 bg-indigo-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-600 focus:ring-0 font-black text-indigo-600 text-2xl text-right transition-all">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-[10px] font-black text-indigo-300 uppercase italic">Amount</span>
                        </div>
                    </div>

                    {{-- Dates --}}
                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-indigo-600 transition-colors">
                            <i data-lucide="calendar" class="w-3 h-3"></i> Issue Date
                        </label>
                        <input type="date" name="invoice_date" value="{{ date('Y-m-d') }}" required
                            class="w-full px-6 py-5 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-indigo-600 focus:ring-0 font-bold text-slate-700 transition-all uppercase">
                    </div>

                    <div class="group">
                        <label class="flex items-center gap-2 text-[10px] font-black text-rose-400 uppercase tracking-[0.2em] mb-4 ml-1 group-focus-within:text-rose-600 transition-colors">
                            <i data-lucide="calendar-alert" class="w-3 h-3"></i> Due Date
                        </label>
                        <input type="date" name="due_date" required
                            class="w-full px-6 py-5 bg-rose-50 border-2 border-transparent rounded-[1.5rem] focus:bg-white focus:border-rose-500 focus:ring-0 font-bold text-rose-700 transition-all uppercase">
                    </div>

                </div>
            </div>
        </div>

        {{-- Right Side: Summary & Action --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white relative overflow-hidden shadow-2xl">
                <div class="relative z-10">
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-6 italic underline underline-offset-8">Summary Preview</h3>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-[11px] font-bold uppercase tracking-tighter italic text-slate-400">
                            <span>Tax (VAT 11%)</span>
                            <span>Calculated...</span>
                        </div>
                        <div class="flex justify-between text-[11px] font-bold uppercase tracking-tighter italic text-slate-400">
                            <span>Status</span>
                            <span class="text-emerald-400">DRAFT (ACTIVE)</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="group w-full py-6 bg-indigo-600 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-indigo-500 shadow-2xl hover:shadow-indigo-500/30 transition-all flex items-center justify-center gap-4 active:scale-95">
                        <i data-lucide="send" class="w-4 h-4 group-hover:-translate-y-1 group-hover:translate-x-1 transition-transform"></i>
                        Publish Invoice
                    </button>
                </div>
                <div class="absolute -bottom-8 -right-8 opacity-10">
                    <i data-lucide="receipt" class="w-40 h-40"></i>
                </div>
            </div>

            <div class="bg-white rounded-[2rem] p-6 border border-slate-100 flex items-center gap-4 group">
                <div class="w-12 h-12 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <i data-lucide="info" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Note</p>
                    <p class="text-[10px] font-bold text-slate-500 mt-1 italic leading-tight">Invoice yang diterbitkan akan langsung terdaftar di Piutang (AR).</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection