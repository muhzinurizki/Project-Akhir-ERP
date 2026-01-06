@extends('layouts.app')

@section('title', 'INV-#' . $salesInvoice->invoice_number . ' | ERP Tekstil')

@section('content')
<div class="max-w-5xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Action Header --}}
    <div class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6 print:hidden">
        <div class="flex items-center gap-6">
            <a href="{{ route('sales-invoices.index') }}" 
               class="w-14 h-14 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 flex items-center justify-center transition-all shadow-sm group">
                <i data-lucide="chevron-left" class="w-6 h-6 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <p class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-1">Financial Document</p>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Invoice <span class="text-slate-400">Detail</span></h1>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="group flex items-center gap-3 px-8 py-4 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="printer" class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors"></i>
                Export / Print
            </button>
            <a href="{{ route('sales-invoices.edit', $salesInvoice) }}" class="flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 hover:shadow-indigo-100">
                <i data-lucide="edit-3" class="w-4 h-4 text-indigo-400"></i>
                Adjust Record
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[3.5rem] shadow-[0_30px_80px_rgba(0,0,0,0.05)] border border-slate-100 overflow-hidden relative">
        {{-- Aesthetic Background Decor --}}
        <div class="absolute top-0 right-0 p-16 opacity-[0.03] pointer-events-none print:hidden">
            <i data-lucide="factory" class="w-64 h-64 -rotate-12"></i>
        </div>

        {{-- Status Ribbon --}}
        @php
            $statusColors = [
                'paid' => 'bg-emerald-500',
                'partial' => 'bg-amber-500',
                'unpaid' => 'bg-slate-900',
                'overdue' => 'bg-rose-600',
            ];
            $currentColor = $statusColors[$salesInvoice->status] ?? 'bg-slate-400';
        @endphp
        <div class="{{ $currentColor }} h-3 w-full"></div>

        <div class="p-10 md:p-20 relative z-10">
            {{-- Top Section: Branding & Meta --}}
            <div class="flex flex-col md:flex-row justify-between gap-16 mb-20">
                <div class="space-y-8">
                    <div class="inline-flex items-center gap-3 px-5 py-2.5 bg-slate-900 rounded-2xl text-white shadow-xl shadow-slate-200">
                        <i data-lucide="layers" class="w-5 h-5 text-indigo-400"></i>
                        <span class="font-black text-[10px] uppercase tracking-[0.2em]">Tekstil<span class="text-indigo-400">ERP</span> Indonesia</span>
                    </div>
                    
                    <div class="space-y-2">
                        <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Client Information</p>
                        <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tighter italic leading-none">{{ $salesInvoice->customer->name }}</h3>
                        <div class="pt-4 flex flex-col gap-2">
                            <p class="text-xs text-slate-500 font-bold max-w-xs italic leading-relaxed">{{ $salesInvoice->customer->address }}</p>
                            <div class="flex items-center gap-2 text-indigo-600 font-black text-[10px] uppercase tracking-widest">
                                <i data-lucide="phone" class="w-3 h-3"></i>
                                {{ $salesInvoice->customer->contact }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-[2.5rem] p-10 grid grid-cols-2 gap-x-12 gap-y-8 border border-slate-100/50">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Ref Number</p>
                        <p class="font-mono font-black text-slate-900 tracking-widest">#{{ $salesInvoice->invoice_number }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Issued Date</p>
                        <p class="font-black text-slate-700 uppercase text-xs">{{ $salesInvoice->invoice_date->format('d M, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Payment Due</p>
                        <p class="font-black text-rose-600 uppercase text-xs underline decoration-2 underline-offset-4">{{ $salesInvoice->due_date->format('d M, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic">Lifecycle</p>
                        <span class="px-3 py-1 {{ $currentColor }} text-white rounded-lg text-[9px] font-black uppercase tracking-widest shadow-lg shadow-current/20">
                            {{ $salesInvoice->status }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Table Content --}}
            <div class="rounded-[2rem] border-2 border-slate-50 overflow-hidden mb-12">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-900 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <tr>
                            <th class="px-10 py-6">Service / Product Description</th>
                            <th class="px-10 py-6 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="px-10 py-10">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 mt-1">
                                        <i data-lucide="package-2" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <p class="font-black text-slate-900 uppercase tracking-tight text-lg">Sales & Textile Distribution</p>
                                        <p class="text-xs text-slate-400 mt-2 font-medium leading-relaxed italic max-w-md">
                                            {{ $salesInvoice->note ?? 'Standard billing for textile materials, logistics, and processing fees as per agreement.' }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-10 text-right font-black text-slate-900 text-xl italic tracking-tighter">
                                Rp {{ number_format($salesInvoice->total_amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Calculation Section --}}
            <div class="flex flex-col items-end space-y-4">
                <div class="w-full md:w-96 p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 space-y-4">
                    <div class="flex justify-between text-[11px] font-black uppercase tracking-widest text-slate-400">
                        <span>Gross Invoiced</span>
                        <span>Rp {{ number_format($salesInvoice->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-[11px] font-black uppercase tracking-widest text-emerald-500">
                        <span>Receipts to Date</span>
                        <span>- Rp {{ number_format($salesInvoice->received_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-4 border-t border-slate-200 flex justify-between items-center text-slate-900">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em]">Balance Due</span>
                        <span class="text-3xl font-black italic tracking-tighter">Rp {{ number_format($salesInvoice->total_amount - $salesInvoice->received_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Legal & Signature --}}
            <div class="mt-24 pt-12 border-t border-slate-100 flex flex-col md:flex-row justify-between items-end gap-12">
                <div class="max-w-sm">
                    <h4 class="text-[10px] font-black text-indigo-600 uppercase tracking-[0.3em] mb-4 italic underline decoration-2 underline-offset-8 leading-none">Standard Terms</h4>
                    <p class="text-[10px] text-slate-400 leading-relaxed font-bold uppercase tracking-wider italic">
                        All payments should be made via Bank Transfer to <span class="text-slate-900">MANDIRI (123-456-7890)</span>. 
                        Please include invoice number <span class="text-indigo-600">#{{ $salesInvoice->invoice_number }}</span> in transfer details.
                    </p>
                </div>
                
                <div class="text-right flex flex-col items-end">
                    <div class="mb-12">
                        <div class="w-40 h-20 border-b-2 border-slate-100 mb-2 relative">
                             {{-- Placeholder for Digital Stamp/Sign --}}
                             <div class="absolute inset-0 flex items-center justify-center opacity-10 -rotate-12 pointer-events-none">
                                <i data-lucide="check-circle-2" class="w-16 h-16 text-emerald-500"></i>
                             </div>
                        </div>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">Authorized Personnel</p>
                    </div>
                    <p class="text-lg font-black text-slate-900 uppercase tracking-tighter italic leading-none underline decoration-indigo-500 decoration-4 underline-offset-4">Finance Controller</p>
                </div>
            </div>
        </div>
    </div>
    
    <p class="text-center mt-12 text-[9px] font-black text-slate-300 uppercase tracking-[0.5em] italic">Electronic Invoice System • Non-Negotiable Document</p>
</div>

<style>
    @media print {
        body { background: white !important; -webkit-print-color-adjust: exact; }
        .max-w-5xl { max-width: 100% !important; padding: 0 !important; }
        header, aside, .print\:hidden { display: none !important; }
        .shadow-xl, .shadow-sm { box-shadow: none !important; }
        .bg-white { border: none !important; }
        .rounded-\[3\.5rem\] { border-radius: 0 !important; }
    }
</style>
@endsection