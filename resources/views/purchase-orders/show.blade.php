@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-8">
        <div class="bg-white rounded-[3rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-12 border-b border-dashed border-slate-200 flex justify-between">
                <div>
                    <h2 class="text-sm font-black text-indigo-600 uppercase tracking-widest mb-1">Purchase Order</h2>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tighter">{{ $po->po_number }}</h1>
                    <p class="text-slate-500 mt-2 font-medium">Date: {{ $po->po_date->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <h3 class="font-black text-slate-900 uppercase italic text-xl">{{ $po->supplier->name }}</h3>
                    <p class="text-slate-500 text-sm max-w-[200px] ml-auto">{{ $po->supplier->address }}</p>
                </div>
            </div>

            <div class="p-12">
                <table class="w-full text-left mb-12">
                    <thead>
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b">
                            <th class="py-4">Item Description</th>
                            <th class="py-4 text-center">Qty</th>
                            <th class="py-4 text-right">Price</th>
                            <th class="py-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($po->items as $item)
                            <tr>
                                <td class="py-4 font-bold text-slate-800">{{ $item->product->name }}</td>
                                <td class="py-4 text-center">{{ number_format($item->qty) }}</td>
                                <td class="py-4 text-right italic">Rp {{ number_format($item->unit_price) }}</td>
                                <td class="py-4 text-right font-black text-slate-900">Rp
                                    {{ number_format($item->total_price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="bg-slate-50 p-8 rounded-3xl ml-auto max-w-xs space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Subtotal</span>
                        <span class="font-bold">Rp {{ number_format($po->subtotal) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">VAT (11%)</span>
                        <span class="font-bold">Rp {{ number_format($po->tax_amount) }}</span>
                    </div>
                    <div class="flex justify-between border-t pt-3 border-slate-200">
                        <span class="font-black uppercase text-xs">Grand Total</span>
                        <span class="font-black text-indigo-600">Rp {{ number_format($po->grand_total) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
