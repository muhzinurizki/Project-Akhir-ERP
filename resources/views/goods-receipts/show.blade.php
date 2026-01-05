@extends('layouts.app')

@section('title', 'Detail Penerimaan #' . $goodsReceipt->gr_number)

@section('content')
<div class="max-w-5xl mx-auto p-4 sm:p-8 pb-20">
    {{-- Action Header --}}
    <div class="flex justify-between items-center mb-8">
        <a href="{{ route('goods-receipts.index') }}" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-slate-900 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <button onclick="window.print()" class="px-6 py-3 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-slate-800 transition-all">
            <i data-lucide="printer" class="w-4 h-4"></i> Cetak Bukti GR
        </button>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-100 overflow-hidden print:border-none print:shadow-none">
        {{-- Banner --}}
        <div class="bg-blue-600 p-12 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-[10px] font-black uppercase tracking-[0.3em] opacity-60 mb-2">Internal Document</h2>
                    <h1 class="text-4xl font-black tracking-tighter italic uppercase">Goods Receipt</h1>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-black italic tracking-tighter">{{ $goodsReceipt->gr_number }}</div>
                    <div class="text-[10px] font-bold uppercase opacity-60 italic">{{ \Carbon\Carbon::parse($goodsReceipt->received_date)->format('d F Y') }}</div>
                </div>
            </div>
        </div>

        <div class="p-12">
            {{-- Info Grid --}}
            <div class="grid grid-cols-2 gap-12 mb-12">
                <div>
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Pengirim</h4>
                    <div class="text-slate-900 font-black text-xl italic tracking-tighter">{{ $goodsReceipt->purchaseOrder->supplier->name }}</div>
                    <div class="text-sm text-slate-500 font-bold mt-1 uppercase tracking-tight">Ref PO: {{ $goodsReceipt->purchaseOrder->po_number }}</div>
                    <div class="text-sm text-slate-500 font-bold mt-1 uppercase tracking-tight text-blue-600">SJ: {{ $goodsReceipt->surat_jalan_number }}</div>
                </div>
                <div class="text-right">
                    <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4">Penerima Gudang</h4>
                    <div class="text-slate-900 font-black text-xl italic tracking-tighter uppercase">{{ $goodsReceipt->user->name }}</div>
                    <div class="text-sm text-slate-500 font-bold mt-1 uppercase tracking-tight">Warehouse Department</div>
                </div>
            </div>

            {{-- Table --}}
            <div class="rounded-3xl border border-slate-100 overflow-hidden mb-8">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-slate-400 text-[9px] uppercase font-black tracking-widest">
                        <tr>
                            <th class="px-6 py-4">Item Material</th>
                            <th class="px-6 py-4 text-center">Dipesan</th>
                            <th class="px-6 py-4 text-right">Diterima</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 font-bold text-slate-700">
                        @foreach($goodsReceipt->items as $item)
                        <tr>
                            <td class="px-6 py-5">
                                <div class="text-slate-900 font-black uppercase italic tracking-tight">{{ $item->product->name }}</div>
                            </td>
                            <td class="px-6 py-5 text-center italic text-slate-400 font-black">
                                {{ number_format($item->qty_ordered, 0) }}
                            </td>
                            <td class="px-6 py-5 text-right font-black text-blue-600 italic">
                                {{ number_format($item->qty_received, 0) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($goodsReceipt->note)
            <div class="p-6 bg-slate-50 rounded-2xl border-l-4 border-blue-600">
                <h5 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Tambahan:</h5>
                <p class="text-sm text-slate-600 italic font-medium">"{{ $goodsReceipt->note }}"</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection