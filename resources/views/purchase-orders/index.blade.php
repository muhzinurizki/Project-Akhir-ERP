@extends('layouts.app')

@section('title', 'Purchase Orders | ERP Tekstil')
@section('page-title', 'Procurement Management')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-8 pb-20">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-slate-900 rounded-[1.5rem] shadow-2xl shadow-slate-200 flex items-center justify-center group">
                <i data-lucide="file-text" class="w-8 h-8 text-white group-hover:scale-110 transition-transform"></i>
            </div>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Purchase Orders</h1>
                <p class="text-slate-500 font-medium flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    Manajemen pesanan pembelian resmi ke supplier
                </p>
            </div>
        </div>

        {{-- Quick Stats / Filter --}}
        <div class="flex items-center gap-3 bg-white p-2 rounded-[1.25rem] border border-slate-100 shadow-sm">
            <div class="px-4 py-2 bg-slate-50 rounded-xl border border-slate-100">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Total Orders</p>
                <p class="text-lg font-black text-slate-900 leading-tight">{{ $pos->count() }}</p>
            </div>
            <a href="{{ route('purchase-requests.index') }}" 
               class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> New From PR
            </a>
        </div>
    </div>

    {{-- Main Table Card --}}
    <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Transaksi</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Mitra Supplier</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Nilai Kontrak</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status Progress</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pos as $po)
                    <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                        <td class="px-10 py-7">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-white group-hover:text-indigo-600 transition-all shadow-sm">
                                    <i data-lucide="hash" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <div class="font-black text-slate-900 uppercase tracking-tight group-hover:text-indigo-600 transition-colors">{{ $po->po_number }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[9px] font-black px-2 py-0.5 bg-slate-100 text-slate-500 rounded-md uppercase tracking-tighter">PR REF: {{ $po->purchaseRequest->pr_number ?? '-' }}</span>
                                        <span class="text-[9px] font-bold text-slate-400 italic">| {{ \Carbon\Carbon::parse($po->po_date)->format('d M, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-7">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-700 uppercase">{{ $po->supplier->name }}</span>
                                <span class="text-[10px] text-slate-400 font-medium flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i> {{ Str::limit($po->supplier->address, 30) }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-7 text-right">
                            <div class="text-sm font-black text-slate-900 tracking-tight">
                                Rp {{ number_format($po->grand_total, 0, ',', '.') }}
                            </div>
                            <div class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest mt-0.5">Sudah Termasuk Pajak</div>
                        </td>
                        <td class="px-8 py-7 text-center">
                            @php
                                $statusClasses = [
                                    'PENDING' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'APPROVED' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'SENT' => 'bg-blue-50 text-blue-600 border-blue-100',
                                    'RECEIVED' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'CANCELLED' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                                $class = $statusClasses[$po->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black border {{ $class }} uppercase tracking-[0.15em] shadow-sm">
                                {{ $po->status }}
                            </span>
                        </td>
                        <td class="px-10 py-7 text-right">
    <div class="flex justify-end gap-2">
        {{-- TOMBOL TERIMA BARANG (Hanya muncul jika status SENT/APPROVED) --}}
        @if($po->status == 'SENT' || $po->status == 'APPROVED')
            <a href="{{ route('goods-receipts.create', ['po_id' => $po->id]) }}" 
               class="flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-xl font-black text-[9px] uppercase tracking-widest hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-100 transition-all active:scale-95">
                <i data-lucide="package-plus" class="w-4 h-4"></i>
                Terima Barang
            </a>
        @endif

        {{-- Link Detail --}}
        <a href="{{ route('purchase-orders.show', $po->id) }}" 
           class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:border-indigo-600 hover:shadow-xl hover:shadow-indigo-100 transition-all"
           title="Lihat Detail">
            <i data-lucide="external-link" class="w-5 h-5"></i>
        </a>

        {{-- Tombol Print --}}
        <button class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:border-rose-600 transition-all"
                title="Cetak PO">
            <i data-lucide="printer" class="w-5 h-5"></i>
        </button>
    </div>
</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-32 text-center bg-slate-50/30">
                            <div class="max-w-md mx-auto flex flex-col items-center">
                                <div class="w-24 h-24 bg-white rounded-[2rem] flex items-center justify-center mb-8 shadow-2xl shadow-slate-200 relative">
                                    <i data-lucide="shopping-bag" class="w-12 h-12 text-slate-200"></i>
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-xs animate-bounce">0</div>
                                </div>
                                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter italic">Belum Ada Transaksi PO</h3>
                                <p class="text-slate-500 font-medium mt-3 leading-relaxed">
                                    Sistem belum menemukan data pesanan pembelian. Pastikan Anda telah menyetujui <a href="{{ route('purchase-requests.index') }}" class="text-indigo-600 font-black underline hover:text-indigo-800">Purchase Request</a> terlebih dahulu.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Footer Table (Pagination Placeholder) --}}
        <div class="px-10 py-6 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
            <span>Menampilkan {{ $pos->count() }} Entitas Transaksi</span>
            <div class="flex gap-2">
                {{-- Pagination Links here if needed --}}
            </div>
        </div>
    </div>
</div>
@endsection