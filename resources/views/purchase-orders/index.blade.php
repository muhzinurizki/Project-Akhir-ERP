@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Purchase Orders</h1>
            <p class="text-sm text-slate-500 font-medium">Kelola pesanan resmi ke supplier.</p>
        </div>
        <a href="{{ route('purchase-orders.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
            Buat PO Baru
        </a>
    </div>

    <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">No. PO</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Supplier</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Total Amount</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($pos as $po)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-6 py-4 font-black text-slate-900 uppercase tracking-tighter">{{ $po->po_number }}</td>
                    <td class="px-6 py-4 text-sm font-bold text-slate-600">{{ $po->supplier->name }}</td>
                    <td class="px-6 py-4 text-sm font-black text-slate-900 text-right">Rp {{ number_format($po->grand_total, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full border text-[10px] font-black uppercase {{ $po->status == 'SENT' ? 'bg-indigo-50 text-indigo-600 border-indigo-200' : 'bg-slate-100' }}">
                            {{ $po->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('purchase-orders.show', $po->id) }}" class="text-indigo-600 font-black text-[10px] uppercase tracking-widest">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-20 text-center text-slate-400 font-bold uppercase text-xs">Belum ada PO.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection