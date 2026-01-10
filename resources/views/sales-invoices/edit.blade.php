@extends('layouts.app')

@section('title', 'Edit Invoice #' . $salesInvoice->invoice_number)

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Header --}}
    <div class="mb-10 flex items-center gap-6">
        <a href="{{ route('sales-invoices.show', $salesInvoice) }}" 
           class="w-12 h-12 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 flex items-center justify-center transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-1">Update Record</p>
            <h1 class="text-2xl font-black text-slate-900 tracking-tighter uppercase italic">Edit Invoice <span class="text-slate-400">#{{ $salesInvoice->invoice_number }}</span></h1>
        </div>
    </div>

    <form action="{{ route('sales-invoices.update', $salesInvoice) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="p-8 md:p-12 space-y-10">
                
                {{-- Customer Section (Read Only / Disabled) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Customer</label>
                        <select name="customer_id" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-bold text-slate-500 cursor-not-allowed" disabled>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ $salesInvoice->customer_id == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-[9px] text-slate-400 italic mt-1">*Customer cannot be changed once invoiced.</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Invoice Number</label>
                        <input type="text" value="{{ $salesInvoice->invoice_number }}" class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl font-mono font-bold text-slate-500 cursor-not-allowed" disabled>
                    </div>
                </div>

                <hr class="border-slate-50">

                {{-- Dates & Amount --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Invoice Date</label>
                        <input type="date" name="invoice_date" value="{{ $salesInvoice->invoice_date->format('Y-m-d') }}" required 
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Due Date</label>
                        <input type="date" name="due_date" value="{{ $salesInvoice->due_date->format('Y-m-d') }}" required 
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-rose-500">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Total Amount (Rp)</label>
                        <input type="number" name="total_amount" value="{{ (int)$salesInvoice->total_amount }}" required 
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-black text-slate-900 text-lg tracking-tighter">
                    </div>
                </div>

                {{-- Status & Notes --}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="md:col-span-1 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Current Status</label>
                        <select name="status" class="w-full px-6 py-4 bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-black text-white text-[10px] uppercase tracking-widest">
                            <option value="unpaid" {{ $salesInvoice->status == 'unpaid' ? 'selected' : '' }}>UNPAID</option>
                            <option value="partial" {{ $salesInvoice->status == 'partial' ? 'selected' : '' }}>PARTIAL</option>
                            <option value="paid" {{ $salesInvoice->status == 'paid' ? 'selected' : '' }}>PAID</option>
                            <option value="overdue" {{ $salesInvoice->status == 'overdue' ? 'selected' : '' }}>OVERDUE</option>
                        </select>
                    </div>

                    <div class="md:col-span-3 space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Internal Notes</label>
                        <input type="text" name="note" value="{{ $salesInvoice->note }}" placeholder="Add additional information here..." 
                               class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-medium text-slate-600 italic text-sm">
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full py-6 bg-indigo-600 text-white rounded-[2rem] font-black text-xs uppercase tracking-[0.3em] hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center justify-center gap-3">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Update Invoice Record
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection