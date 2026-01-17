@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Sales Orders</h1>
            <p class="text-sm text-slate-500 font-medium">Kelola pesanan pelanggan dan status konfirmasi.</p>
        </div>
        {{-- Hanya Sales & Admin yang bisa buat SO baru --}}
        @if(in_array(auth()->user()->role, ['super_admin', 'staff']))
        <a href="{{ route('sales-orders.create') }}" class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-2xl transition-all shadow-sm text-sm font-bold">
            <i data-lucide="plus-circle" class="w-4 h-4"></i>
            Buat Pesanan Baru
        </a>
        @endif
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr class="text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                    <th class="px-8 py-5">No. Pesanan</th>
                    <th class="px-8 py-5">Pelanggan</th>
                    <th class="px-8 py-5">Tanggal</th>
                    <th class="px-8 py-5 text-center">Status</th>
                    <th class="px-8 py-5">Input Oleh</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($orders as $order)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-8 py-5 font-bold text-indigo-600 uppercase italic">{{ $order->so_number }}</td>
                    <td class="px-8 py-5">
                        <span class="font-bold text-slate-700 block">{{ $order->customer->name }}</span>
                        <span class="text-[10px] text-slate-400 font-medium italic">{{ $order->customer->phone ?? 'No Phone' }}</span>
                    </td>
                    <td class="px-8 py-5 text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 rounded-full text-[9px] font-black tracking-tighter uppercase
                            {{ $order->status == 'CONFIRMED' ? 'bg-emerald-100 text-emerald-600' : ($order->status == 'CANCELLED' ? 'bg-rose-100 text-rose-600' : 'bg-slate-100 text-slate-500') }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-xs font-semibold text-slate-600">{{ $order->user->name }}</td>
                    <td class="px-8 py-5 text-center">
                        <a href="{{ route('sales-orders.show', $order->id) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-xl bg-slate-50 text-slate-400 hover:bg-indigo-600 hover:text-white transition-all shadow-sm">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection