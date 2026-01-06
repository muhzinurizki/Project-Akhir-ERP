@extends('layouts.app')

@section('title', 'Receivables Hub | ERP Tekstil')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 bg-white border border-slate-100 rounded-[2.5rem] shadow-xl flex items-center justify-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-indigo-600 translate-y-20 group-hover:translate-y-0 transition-transform duration-500"></div>
                <i data-lucide="landmark" class="w-10 h-10 text-slate-900 group-hover:text-white transition-colors duration-500 relative z-10"></i>
            </div>
            <div>
                <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Account <span class="text-indigo-600">Receivable</span></h1>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 flex items-center gap-2">
                    <span class="w-8 h-[2px] bg-indigo-600"></span>
                    Liquidity & Collection Monitor
                </p>
            </div>
        </div>
        
        <a href="{{ route('sales-invoices.create') }}" class="group flex items-center gap-4 px-10 py-5 bg-slate-900 text-white rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all duration-500 shadow-2xl shadow-slate-200 hover:shadow-indigo-200 active:scale-95">
            <i data-lucide="plus-circle" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
            Generate New Invoice
        </a>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="group relative bg-indigo-600 rounded-[3rem] p-8 text-white overflow-hidden shadow-2xl shadow-indigo-200 transition-transform hover:-translate-y-1 duration-500">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-200 mb-6">Total Outstanding Piutang</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-sm font-bold opacity-60 italic uppercase">IDR</span>
                    <h3 class="text-4xl font-black tracking-tighter italic leading-none">{{ number_format($stats['total_ar'], 0, ',', '.') }}</h3>
                </div>
                <div class="mt-8 py-3 px-4 bg-white/10 rounded-2xl inline-flex items-center gap-2 backdrop-blur-sm border border-white/10">
                    <i data-lucide="trending-up" class="w-3.5 h-3.5 text-indigo-200"></i>
                    <span class="text-[9px] font-black uppercase tracking-widest text-white">Expected Cash Inflow</span>
                </div>
            </div>
            <i data-lucide="wallet-cards" class="absolute -bottom-6 -right-6 w-32 h-32 text-indigo-500/30 -rotate-12 group-hover:scale-110 transition-transform duration-700"></i>
        </div>

        <div class="bg-white rounded-[3rem] p-8 border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.03)] flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500 mb-6">
                    <i data-lucide="alert-octagon" class="w-6 h-6"></i>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-500/70 mb-2">Critical Overdue</p>
                <h3 class="text-4xl font-black tracking-tighter text-slate-900 italic leading-none">{{ $stats['overdue_count'] }} <span class="text-xs font-black text-slate-300 uppercase italic tracking-normal ml-1">Entries</span></h3>
            </div>
            <p class="mt-6 text-[10px] font-black text-slate-400 uppercase tracking-widest border-t border-slate-50 pt-6">Urgent Follow-up required</p>
        </div>

        <div class="bg-slate-900 rounded-[3rem] p-8 text-white shadow-2xl shadow-slate-200 overflow-hidden relative group">
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 mb-6 italic">Scheduled Collection (7D)</p>
                    <div class="flex items-baseline gap-2">
                        <span class="text-sm font-bold opacity-30 italic uppercase">IDR</span>
                        <h3 class="text-4xl font-black tracking-tighter italic leading-none text-emerald-400">{{ number_format($stats['upcoming_collection'], 0, ',', '.') }}</h3>
                    </div>
                </div>
                <div class="mt-8 flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-500">System Ready for Receipt</span>
                </div>
            </div>
            <i data-lucide="calendar-clock" class="absolute -bottom-6 -right-6 w-32 h-32 text-slate-800 -rotate-12"></i>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] bg-slate-50/50">
                        <th class="px-10 py-8">Entity & Document</th>
                        <th class="px-8 py-8 text-center">Collection Due</th>
                        <th class="px-8 py-8 text-right">Invoiced Amount</th>
                        <th class="px-8 py-8 text-right">Balance Due</th>
                        <th class="px-8 py-8 text-center">Lifecycle</th>
                        <th class="px-10 py-8 text-right">Ops</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($invoices as $inv)
                    <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:bg-white transition-all shadow-sm">
                                    <i data-lucide="file-text" class="w-5 h-5 text-slate-400 group-hover:text-indigo-600"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-base font-black text-slate-900 uppercase tracking-tight group-hover:text-indigo-600 transition-colors">{{ $inv->customer->name }}</span>
                                    <span class="text-[10px] font-mono font-black text-slate-400 tracking-widest">INV/{{ $inv->invoice_number }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8 text-center">
                            @php $isOverdue = $inv->due_date < now() && $inv->status != 'paid'; @endphp
                            <div class="inline-flex flex-col items-center">
                                <span class="text-xs font-black {{ $isOverdue ? 'text-rose-500' : 'text-slate-600' }} uppercase italic tracking-tighter">
                                    {{ $inv->due_date->format('d M Y') }}
                                </span>
                                @if($isOverdue)
                                    <span class="text-[9px] font-black text-rose-300 uppercase mt-0.5 tracking-widest">Overdue</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-8 text-right font-bold text-slate-400 text-xs">
                            {{ number_format($inv->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-8 text-right">
                            <span class="text-base font-black text-slate-900 italic tracking-tighter">
                                {{ number_format($inv->total_amount - $inv->received_amount, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="px-8 py-8 text-center">
                            @php
                                $statusStyles = [
                                    'paid' => 'bg-emerald-500 text-white shadow-emerald-100',
                                    'partial' => 'bg-amber-500 text-white shadow-amber-100',
                                    'unpaid' => 'bg-slate-900 text-white shadow-slate-100'
                                ];
                                $currentStyle = $statusStyles[$inv->status] ?? 'bg-slate-100 text-slate-400';
                            @endphp
                            <span class="px-4 py-2 rounded-xl {{ $currentStyle }} text-[9px] font-black uppercase tracking-[0.2em] shadow-lg">
                                {{ $inv->status }}
                            </span>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                                <a href="{{ route('sales-invoices.edit', $inv) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:shadow-xl hover:shadow-indigo-500/10 flex items-center justify-center transition-all">
                                    <i data-lucide="eye" class="w-4 h-4"></i>
                                </a>
                                <button class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-emerald-500 hover:border-emerald-100 flex items-center justify-center transition-all">
                                    <i data-lucide="receipt" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection