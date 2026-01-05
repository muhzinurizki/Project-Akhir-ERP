@extends('layouts.app')

@section('title', 'Edit Invoice | ERP Tekstil')

@section('content')
<div class="max-w-4xl mx-auto p-8 pb-20">
    
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('purchase-invoices.index') }}" 
               class="p-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition-all shadow-sm group">
                <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase">Modify Invoice</h1>
                <p class="text-slate-500 text-sm font-medium">Ref: <span class="text-indigo-600 font-bold font-mono">{{ $purchaseInvoice->invoice_number }}</span></p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('purchase-invoices.update', $purchaseInvoice) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Supplier Vendor</label>
                    <select name="supplier_id" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $purchaseInvoice->supplier_id == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Invoice Number</label>
                    <input type="text" name="invoice_number" value="{{ old('invoice_number', $purchaseInvoice->invoice_number) }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Total Bill Amount (Rp)</label>
                    <input type="number" name="total_amount" value="{{ old('total_amount', (int)$purchaseInvoice->total_amount) }}" required
                        class="w-full px-5 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-black text-indigo-600 text-lg">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Invoice Date</label>
                    <input type="date" name="invoice_date" value="{{ $purchaseInvoice->invoice_date->format('Y-m-d') }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Payment Due Date</label>
                    <input type="date" name="due_date" value="{{ $purchaseInvoice->due_date->format('Y-m-d') }}" required
                        class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Notes / Description</label>
                    <textarea name="note" rows="3" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-medium text-slate-700">{{ old('note', $purchaseInvoice->note) }}</textarea>
                </div>
            </div>

            {{-- Warning if already paid --}}
            @if($purchaseInvoice->paid_amount > 0)
            <div class="mt-8 p-4 bg-amber-50 rounded-2xl border border-amber-100 flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 text-amber-500"></i>
                <p class="text-[10px] font-bold text-amber-700 uppercase tracking-widest">
                    Nota ini sudah memiliki riwayat pembayaran sebesar Rp {{ number_format($purchaseInvoice->paid_amount, 0, ',', '.') }}. Perubahan nominal tagihan akan menyesuaikan status pelunasan otomatis.
                </p>
            </div>
            @endif

            <div class="mt-10 flex gap-4">
                <button type="submit" class="flex-1 py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-800 shadow-xl transition-all flex items-center justify-center gap-3">
                    <i data-lucide="refresh-cw" class="w-4 h-4 text-indigo-400"></i>
                    Update Ledger
                </button>
                <a href="{{ route('purchase-invoices.index') }}" class="py-5 px-8 bg-white border border-slate-200 text-slate-400 rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-50 transition-all">
                    Cancel
                </a>
            </div>
        </div>
    </form>
</div>
@endsection