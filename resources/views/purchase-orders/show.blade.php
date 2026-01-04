@extends('layouts.app')

@section('title', 'PO Detail: ' . $purchaseOrder->po_number)

@section('content')
<div class="max-w-6xl mx-auto p-4 sm:p-8 pb-20">
    {{-- Top Navigation & Utility --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12 no-print">
        <div>
            <a href="{{ route('purchase-orders.index') }}" class="group text-slate-400 hover:text-slate-900 flex items-center gap-2 font-black text-[10px] uppercase tracking-[0.2em] mb-4 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> Kembali ke Daftar PO
            </a>
            <div class="flex items-center gap-4">
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Detail Pesanan</h1>
                <div class="h-8 w-[2px] bg-slate-200 rotate-12"></div>
                <span class="px-4 py-1.5 rounded-full text-[10px] font-black border bg-indigo-50 text-indigo-600 border-indigo-100 uppercase tracking-widest shadow-sm">
                    {{ $purchaseOrder->status }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="px-6 py-3 bg-slate-900 text-white rounded-2xl font-black hover:bg-slate-800 transition-all text-xs shadow-xl shadow-slate-200 flex items-center gap-3 uppercase tracking-widest">
                <i data-lucide="printer" class="w-4 h-4"></i> Cetak Dokumen Resmi
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Left Side: Main Document --}}
        <div class="lg:col-span-3 space-y-8">
            <div class="bg-white rounded-[3rem] border border-slate-100 shadow-[0_20px_50px_rgba(0,0,0,0.02)] overflow-hidden">
                {{-- Document Header --}}
                <div class="p-10 border-b border-slate-50 flex flex-col md:flex-row justify-between items-start gap-8 bg-slate-50/30">
                    <div class="space-y-4">
                        <div class="w-16 h-16 bg-slate-900 rounded-2xl flex items-center justify-center text-white font-black text-2xl shadow-xl">E</div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-1">Identifikasi Dokumen</p>
                            <p class="text-2xl font-black text-slate-900 tracking-tighter">{{ $purchaseOrder->po_number }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-8 text-right">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tanggal Terbit</p>
                            <p class="text-sm font-black text-slate-900 uppercase italic">{{ \Carbon\Carbon::parse($purchaseOrder->po_date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Metode Pengiriman</p>
                            <p class="text-sm font-black text-slate-900 uppercase italic">FOB Destination</p>
                        </div>
                    </div>
                </div>

                {{-- Table Section --}}
                <div class="p-2">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">
                                <th class="px-8 py-6">Deskripsi Produk</th>
                                <th class="px-4 py-6 text-center">Volume</th>
                                <th class="px-8 py-6 text-right">Harga Satuan</th>
                                <th class="px-8 py-6 text-right">Total Nilai</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($purchaseOrder->items as $item)
                            <tr class="group">
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-black text-slate-900 uppercase italic tracking-tight group-hover:text-indigo-600 transition-colors">{{ $item->product->name }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 mt-1">SKU: {{ $item->product->code }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-6 text-center text-slate-600 font-black italic">
                                    {{ number_format($item->qty, 0) }} <span class="text-[9px] uppercase font-bold text-slate-400 ml-1">{{ $item->product->unit->name }}</span>
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-slate-600">
                                    <span class="text-[10px] mr-1 italic text-slate-300">IDR</span>{{ number_format($item->unit_price, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-6 text-right font-black text-slate-900 tracking-tighter">
                                    <span class="text-[10px] mr-1 italic text-slate-300">IDR</span>{{ number_format($item->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Financial Summary --}}
                <div class="p-10 bg-slate-900 text-white flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="hidden md:block">
                        <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.4em] mb-2 font-mono italic text-white/50">Official Purchase Order Certificate</p>
                        <div class="flex gap-4 opacity-30">
                            <i data-lucide="qr-code" class="w-12 h-12"></i>
                            <i data-lucide="shield-check" class="w-12 h-12"></i>
                        </div>
                    </div>
                    <div class="w-full md:w-80 space-y-3">
                        <div class="flex justify-between items-center text-white/50 italic font-bold">
                            <span class="text-[10px] font-black uppercase tracking-widest">Subtotal Nilai</span>
                            <span class="text-sm">Rp {{ number_format($purchaseOrder->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-white/50 italic font-bold">
                            <span class="text-[10px] font-black uppercase tracking-widest">Pajak ({{ $purchaseOrder->tax_percent }}%)</span>
                            <span class="text-sm">Rp {{ number_format($purchaseOrder->tax_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-4 border-t border-white/10 flex justify-between items-center">
                            <span class="text-xs font-black uppercase tracking-[0.2em] text-emerald-400">Total Tagihan</span>
                            <span class="text-3xl font-black text-emerald-400 tracking-tighter italic">Rp {{ number_format($purchaseOrder->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex-1 bg-slate-50 p-8 rounded-[2rem] border border-slate-100">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <i data-lucide="info" class="w-4 h-4"></i> Catatan Syarat & Ketentuan
                    </h4>
                    <p class="text-xs text-slate-600 leading-relaxed font-bold italic">
                        {{ $purchaseOrder->note ?? 'Mohon kirimkan barang sesuai dengan spesifikasi yang tertera. Faktur tagihan harus melampirkan nomor PO ini.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Side: Info Panel --}}
        <div class="space-y-6 no-print">
            {{-- Supplier Card --}}
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                    <i data-lucide="truck" class="w-20 h-20 -mr-6 -mt-6"></i>
                </div>
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6 relative z-10">Data Supplier</h3>
                <div class="relative z-10">
                    <p class="text-xl font-black text-slate-900 uppercase italic tracking-tighter">{{ $purchaseOrder->supplier->name }}</p>
                    <p class="text-[10px] font-bold text-indigo-600 uppercase mt-1 tracking-widest font-mono">{{ $purchaseOrder->supplier->code }}</p>
                    
                    <div class="mt-6 pt-6 border-t border-slate-50 space-y-4">
                        <div class="flex items-start gap-3">
                            <i data-lucide="map-pin" class="w-4 h-4 text-slate-300 mt-1"></i>
                            <p class="text-[11px] text-slate-500 font-bold leading-relaxed italic">{{ $purchaseOrder->supplier->address }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-300"></i>
                            <p class="text-[11px] text-slate-900 font-black italic">{{ $purchaseOrder->supplier->email }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Reference Card --}}
            <div class="bg-indigo-600 p-8 rounded-[2.5rem] text-white shadow-xl shadow-indigo-100 relative overflow-hidden">
                <div class="absolute -bottom-4 -right-4 opacity-10">
                    <i data-lucide="file-check" class="w-24 h-24"></i>
                </div>
                <h3 class="text-[10px] font-black text-indigo-200 uppercase tracking-[0.2em] mb-4">Referensi PR</h3>
                <p class="text-sm font-black italic tracking-tighter uppercase">{{ $purchaseOrder->purchaseRequest->pr_number }}</p>
                <div class="mt-4 flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-indigo-300 animate-pulse"></div>
                    <span class="text-[9px] font-black uppercase text-indigo-100">Dokumen Telah Disinkronisasi</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Print Styles --}}
<style>
    @media print {
        header, aside, nav, .no-print { display: none !important; }
        .max-w-6xl { max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
        body { background: white !important; font-size: 12pt; }
        .bg-slate-900 { background-color: #0f172a !important; color: white !important; -webkit-print-color-adjust: exact; }
        .bg-slate-50\/30 { background-color: #f8fafc !important; -webkit-print-color-adjust: exact; }
        .text-emerald-400 { color: #34d399 !important; -webkit-print-color-adjust: exact; }
        .rounded-[3rem], .rounded-2xl, .rounded-xl { border-radius: 10px !important; }
        table { border: 1px solid #e2e8f0; }
        th { background-color: #f1f5f9 !important; -webkit-print-color-adjust: exact; }
    </div>
</style>
@endsection