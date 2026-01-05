@extends('layouts.app')

@section('title', 'Data Penerimaan Barang | ERP Tekstil')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">History Goods Receipt</h1>
            <p class="text-slate-500 font-medium">Daftar penerimaan barang masuk ke gudang.</p>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-widest border-b border-slate-100">
                    <th class="px-8 py-6">No. Receipt / Tanggal</th>
                    <th class="px-6 py-6">Referensi PO</th>
                    <th class="px-6 py-6">Surat Jalan</th>
                    <th class="px-6 py-6 text-center">Petugas</th>
                    <th class="px-8 py-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($grs as $gr)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-6">
                        <div class="font-black text-slate-900 tracking-tight">{{ $gr->gr_number }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase">{{ \Carbon\Carbon::parse($gr->received_date)->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-6">
                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-lg text-[10px] font-black uppercase italic tracking-tighter">
                            {{ $gr->purchaseOrder->po_number }}
                        </span>
                    </td>
                    <td class="px-6 py-6 text-slate-600 font-bold text-sm">
                        {{ $gr->surat_jalan_number ?? '-' }}
                    </td>
                    <td class="px-6 py-6 text-center text-sm font-bold text-slate-700">
                        {{ $gr->user->name }}
                    </td>
                    <td class="px-8 py-6 text-right">
                        <a href="{{ route('goods-receipts.show', $gr->id) }}" class="inline-flex items-center justify-center w-10 h-10 bg-slate-100 text-slate-900 rounded-xl hover:bg-blue-600 hover:text-white transition-all group">
                            <i data-lucide="eye" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-20 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 bg-slate-50 rounded-3xl flex items-center justify-center mb-4">
                                <i data-lucide="package-x" class="w-10 h-10 text-slate-200"></i>
                            </div>
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.2em]">Belum ada data penerimaan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="p-6 border-t border-slate-50">
            {{ $grs->links() }}
        </div>
    </div>
</div>
@endsection