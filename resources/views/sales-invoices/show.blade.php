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
                    <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Invoice
                        <span class="text-slate-400">Detail</span></h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="window.print()"
                    class="group flex items-center gap-3 px-8 py-4 bg-white border border-slate-200 text-slate-600 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                    <i data-lucide="printer" class="w-4 h-4 text-slate-400 group-hover:text-indigo-600 transition-colors"></i>
                    Export / Print
                </button>
                <a href="{{ route('sales-invoices.edit', $salesInvoice) }}"
                    class="flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 hover:shadow-indigo-100">
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
                    'overdue' => 'bg-rose-600'
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
                            <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tighter italic leading-none">
                                {{ $salesInvoice->customer->name }}</h3>
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
                                                {{ $salesInvoice->note ?? 'Standard billing for textile materials, logistics, and processing fees.' }}
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

                {{-- Payment History (FIXED: Out of the main table) --}}
                <div class="mb-12">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-[10px] font-black text-slate-900 uppercase tracking-[0.2em] italic underline decoration-indigo-500 decoration-2 underline-offset-8">
                            Payment History History</h4>
                        @if ($salesInvoice->status != 'paid')
                            <button onclick="document.getElementById('paymentModal').classList.remove('hidden')"
                                class="group text-[10px] font-black uppercase tracking-widest text-indigo-600 hover:text-indigo-800 transition-colors flex items-center gap-2">
                                <i data-lucide="plus-circle" class="w-4 h-4 transition-transform group-hover:rotate-90"></i> Record Payment
                            </button>
                        @endif
                    </div>

                    <div class="rounded-3xl border border-dashed border-slate-200 overflow-hidden">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 text-[9px] text-slate-400 font-black uppercase tracking-widest">
                                <tr>
                                    <th class="px-8 py-4">Date</th>
                                    <th class="px-8 py-4 text-center">Method</th>
                                    <th class="px-8 py-4">Reference</th>
                                    <th class="px-8 py-4 text-right">Amount</th>
                                    <th class="px-8 py-4 text-center print:hidden"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50 text-xs font-bold text-slate-600 italic">
                                @forelse($salesInvoice->arPayments as $payment)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-8 py-4">{{ $payment->payment_date->format('d/m/Y') }}</td>
                                        <td class="px-8 py-4 text-center italic text-[10px] uppercase text-slate-400">{{ $payment->payment_method }}</td>
                                        <td class="px-8 py-4 font-mono text-[10px]">{{ $payment->reference_number ?? '-' }}</td>
                                        <td class="px-8 py-4 text-right text-emerald-600 font-black tracking-tighter">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                        <td class="px-8 py-4 text-center print:hidden">
                                            <form action="{{ route('ar-payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Hapus record bayar ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-300 hover:text-rose-600 transition-colors"><i data-lucide="trash-2" class="w-4 h-4 mx-auto"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-8 py-10 text-center text-slate-300 uppercase tracking-widest text-[10px]">No Payment Detected</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Calculation Section --}}
                <div class="flex flex-col items-end space-y-4">
                    <div class="w-full md:w-96 p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100 space-y-4 shadow-sm">
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
                                <div class="absolute inset-0 flex items-center justify-center opacity-10 -rotate-12 pointer-events-none">
                                    <i data-lucide="check-circle-2" class="w-16 h-16 text-emerald-500"></i>
                                </div>
                            </div>
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-[0.4em]">Authorized Personnel</p>
                        </div>
                        <p class="text-lg font-black text-slate-900 uppercase tracking-tighter italic leading-none underline decoration-indigo-500 decoration-4 underline-offset-4">
                            Finance Controller</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center mt-12 text-[9px] font-black text-slate-300 uppercase tracking-[0.5em] italic">Electronic Invoice System • Non-Negotiable Document</p>
    </div>

    {{-- MODAL AR PAYMENT (STAYS HERE) --}}
    <div id="paymentModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[99] hidden flex items-center justify-center p-4 print:hidden">
        <div class="bg-white rounded-[3rem] w-full max-w-lg shadow-2xl overflow-hidden animate-in zoom-in duration-300">
            <div class="p-10 border-b border-slate-50 flex justify-between items-center bg-indigo-50/30">
                <h3 class="text-xl font-black text-indigo-900 tracking-tighter uppercase italic">Record Payment</h3>
                <button onclick="document.getElementById('paymentModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i data-lucide="x-circle" class="w-8 h-8"></i>
                </button>
            </div>
            
            <form action="{{ route('ar-payments.store') }}" method="POST" class="p-10 space-y-8">
                @csrf
                <input type="hidden" name="sales_invoice_id" value="{{ $salesInvoice->id }}">
                
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Payment Amount (Rp)</label>
                    <input type="number" name="amount" max="{{ $salesInvoice->total_amount - $salesInvoice->received_amount }}" required 
                        class="w-full px-6 py-5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 font-black text-indigo-600 text-2xl tracking-tighter" 
                        value="{{ $salesInvoice->total_amount - $salesInvoice->received_amount }}">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Date</label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Method</label>
                        <select name="payment_method" required class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                            <option value="Transfer">Bank Transfer</option>
                            <option value="Cash">Cash / Tunai</option>
                            <option value="Cheque">Giro / Cheque</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Reference / Bank Info</label>
                    <input type="text" name="reference_number" placeholder="Contoh: MANDIRI - Ref 99283" class="w-full px-5 py-4 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-indigo-600 font-bold text-slate-700">
                </div>

                <button type="submit" class="w-full py-6 bg-indigo-600 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all">
                    Finalize Payment
                </button>
            </form>
        </div>
    </div>

    <style>
        @media print {
            body { background: white !important; -webkit-print-color-adjust: exact; }
            .max-w-5xl { max-width: 100% !important; padding: 0 !important; }
            header, aside, .print\:hidden, nav { display: none !important; }
            .shadow-xl, .shadow-sm, .shadow-2xl { box-shadow: none !important; }
            .bg-white { border: none !important; }
            .rounded-\[3\.5rem\] { border-radius: 0 !important; }
        }
    </style>
@endsection