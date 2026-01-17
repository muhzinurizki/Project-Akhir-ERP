@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Delivery Orders</h1>
            <p class="text-sm text-slate-500">Daftar pengiriman barang ke pelanggan.</p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50/50">
                <tr class="text-slate-400 text-[10px] uppercase font-bold tracking-widest">
                    <th class="px-8 py-5">No. DO</th>
                    <th class="px-8 py-5">No. SO</th>
                    <th class="px-8 py-5">Pelanggan</th>
                    <th class="px-8 py-5">Gudang Asal</th>
                    <th class="px-8 py-5">Tgl Kirim</th>
                    <th class="px-8 py-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($deliveryOrders as $do)
                <tr class="hover:bg-slate-50/50">
                    <td class="px-8 py-5 font-bold text-indigo-600 uppercase">{{ $do->do_number }}</td>
                    <td class="px-8 py-5 text-slate-500">{{ $do->salesOrder->so_number }}</td>
                    <td class="px-8 py-5 font-semibold text-slate-700">{{ $do->salesOrder->customer->name }}</td>
                    <td class="px-8 py-5 text-slate-600">{{ $do->warehouse->name }}</td>
                    <td class="px-8 py-5 text-slate-500">{{ \Carbon\Carbon::parse($do->delivery_date)->format('d/m/Y') }}</td>
                    <td class="px-8 py-5 text-center">
                        <a href="{{ route('delivery-orders.show', $do->id) }}" class="p-2 bg-slate-100 rounded-xl inline-block hover:bg-indigo-600 hover:text-white">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-400 italic">Belum ada data pengiriman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-6">{{ $deliveryOrders->links() }}</div>
    </div>
</div>
@endsection