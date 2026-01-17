@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6 max-w-5xl mx-auto">
    {{-- Header Detail --}}
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('sales-orders.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:text-indigo-600 transition-all">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <div>
                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded italic">{{ $order->so_number }}</span>
                <h1 class="text-2xl font-bold text-slate-800 mt-2">Detail Pesanan</h1>
            </div>
        </div>

        {{-- Actions based on Status & Role --}}
        <div class="flex gap-3">
            @if($order->status == 'DRAFT' && in_array(auth()->user()->role, ['super_admin', 'manager']))
            <form action="{{ route('sales-orders.confirm', $order->id) }}" method="POST">
                @csrf
                <button class="bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-100 text-xs uppercase tracking-widest">
                    Confirm Order
                </button>
            </form>
            @endif

            {{-- Warehouse Staff can create DO if SO is Confirmed --}}
            @if($order->status == 'CONFIRMED' && in_array(auth()->user()->role, ['super_admin', 'staff']))
            <a href="{{ route('delivery-orders.create', ['so_id' => $order->id]) }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 text-xs uppercase tracking-widest">
                Proses Pengiriman (DO)
            </a>
            @endif
        </div>
    </div>

    {{-- Information Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-50 font-bold text-slate-800 text-sm tracking-widest uppercase bg-slate-50/30">Daftar Barang</div>
                <table class="w-full text-left">
                    <thead class="text-slate-400 text-[10px] uppercase font-bold tracking-widest bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-4">Produk</th>
                            <th class="px-8 py-4 text-right">Quantity</th>
                            <th class="px-8 py-4 text-right">Terkirim</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-8 py-5 font-bold text-slate-700">{{ $item->product->name }}</td>
                            <td class="px-8 py-5 text-right font-black text-slate-800 text-lg">{{ $item->quantity }}</td>
                            <td class="px-8 py-5 text-right font-bold text-emerald-600 italic">{{ $item->shipped_quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Pelanggan</h3>
                <div class="p-4 bg-slate-50 rounded-2xl">
                    <p class="font-black text-slate-800 uppercase italic">{{ $order->customer->name }}</p>
                    <p class="text-xs text-slate-500 mt-1 font-medium">{{ $order->customer->address }}</p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Catatan Pesanan</h3>
                <p class="text-xs text-slate-500 font-medium italic">{{ $order->note ?? 'Tidak ada catatan.' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection