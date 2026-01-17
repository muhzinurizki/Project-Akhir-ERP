@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8 flex items-center gap-5">
        <a href="{{ route('sales-orders.show', $salesOrder->id) }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 shadow-sm">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 italic uppercase">Create Delivery Order</h1>
            <p class="text-sm text-slate-500">Memproses pengiriman untuk <b>{{ $salesOrder->so_number }}</b></p>
        </div>
    </div>

    <form action="{{ route('delivery-orders.store') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm">
        @csrf
        <input type="hidden" name="sales_order_id" value="{{ $salesOrder->id }}">

        <div class="p-10 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">No. Delivery Order</label>
                    <input type="text" name="do_number" value="{{ $do_number }}" readonly class="w-full rounded-2xl border-none bg-slate-50 font-black text-indigo-600 p-4">
                </div>
                <div class="space-y-3">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Pilih Gudang Pengirim</label>
                    <select name="warehouse_id" required class="w-full rounded-2xl border-slate-100 bg-slate-50 font-bold p-4 appearance-none">
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="space-y-3">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Tanggal Pengiriman</label>
                <input type="date" name="delivery_date" value="{{ date('Y-m-d') }}" required class="w-full rounded-2xl border-slate-100 bg-slate-50 font-bold p-4">
            </div>

            {{-- Ringkasan Barang --}}
            <div class="pt-8 border-t border-slate-50">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Barang yang akan dikirim:</h3>
                <div class="bg-slate-50 rounded-3xl p-6">
                    @foreach($salesOrder->items as $item)
                    <div class="flex justify-between items-center py-2">
                        <span class="font-bold text-slate-700">{{ $item->product->name }}</span>
                        <span class="font-black text-slate-800">{{ $item->quantity }} {{ $item->product->unit->code ?? 'Unit' }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="p-10 bg-slate-50/50">
            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100 uppercase tracking-widest text-xs">
                Konfirmasi & Potong Stok Sekarang
            </button>
        </div>
    </form>
</div>
@endsection