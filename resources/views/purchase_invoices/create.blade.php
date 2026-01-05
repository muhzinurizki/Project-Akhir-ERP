@extends('layouts.app')

@section('title', 'New Invoice | ERP Tekstil')

@section('content')
<div class="max-w-4xl mx-auto p-8 pb-20">
    
    {{-- Navigation Header --}}
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('purchase-invoices.index') }}" 
               class="p-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition-all shadow-sm group">
                <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Record Invoice</h1>
                <p class="text-slate-500 text-sm font-medium">Input tagihan baru dari supplier</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('purchase-invoices.store') }}" class="space-y-8">
        @csrf
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Supplier Selection --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Supplier Vendor</label>
                    <select name="supplier_id" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                        <option value="">Pilih Supplier...</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }} ({{ $supplier->code }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- Invoice Number --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Invoice Number</label>
                    <input type="text" name="invoice_number" required placeholder="INV/SUP/2024/001"
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700 shadow-inner">
                </div>

                {{-- Total Amount --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Total Bill Amount (Rp)</label>
                    <input type="number" name="total_amount" required
                        class="w-full px-5 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-black text-indigo-600 shadow-inner text-lg">
                </div>

                {{-- Invoice Date --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Invoice Date</label>
                    <input type="date" name="invoice_date" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700 shadow-inner">
                </div>

                {{-- Due Date --}}
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Payment Due Date</label>
                    <input type="date" name="due_date" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700 shadow-inner">
                </div>

                {{-- Notes --}}
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Notes / Description</label>
                    <textarea name="note" rows="3" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-medium text-slate-700 shadow-inner"></textarea>
                </div>
            </div>

            <div class="mt-10">
                <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-800 shadow-2xl transition-all flex items-center justify-center gap-3">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Post to Ledger
                </button>
            </div>
        </div>
    </form>
</div>
@endsection