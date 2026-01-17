@extends('layouts.app')

@section('content')
<div class="p-6 space-y-6">
    {{-- Product Header Card --}}
    <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-6">
            <a href="{{ route('inventory.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-400 hover:text-indigo-600 transition-all">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <div>
                <span class="text-[10px] font-black text-indigo-500 uppercase tracking-widest bg-indigo-50 px-2 py-1 rounded italic">{{ $product->sku }}</span>
                <h1 class="text-2xl font-bold text-slate-800 mt-2 tracking-tight">{{ $product->name }}</h1>
                <p class="text-xs text-slate-400 font-semibold uppercase tracking-widest">Inventory Ledger Traceability Log</p>
            </div>
        </div>
        <div class="bg-indigo-600 text-white px-10 py-5 rounded-[2rem] text-center shadow-lg shadow-indigo-100 min-w-[200px]">
            <p class="text-[9px] font-bold uppercase tracking-[0.3em] text-indigo-200 mb-1">Final Stock Balance</p>
            <p class="text-4xl font-black tracking-tighter italic">{{ number_format($product->stock_total, 0) }}</p>
            <p class="text-[10px] font-bold uppercase text-indigo-200">{{ $product->unit->name }}</p>
        </div>
    </div>

    {{-- Movements Log Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-50 bg-slate-50/20 flex justify-between items-center">
            <h3 class="font-bold text-slate-800 text-xs tracking-widest uppercase px-2">Transaction History</h3>
            <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase">
                <i data-lucide="clock" class="w-3 h-3 text-emerald-500"></i> Real-time Ledger
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-slate-400 text-[10px] uppercase tracking-[0.15em] font-bold">
                        <th class="px-8 py-5">Date & Time</th>
                        <th class="px-8 py-5">Officer (Admin)</th>
                        <th class="px-8 py-5 text-center">Type</th>
                        <th class="px-8 py-5 text-right">Mutation</th>
                        <th class="px-8 py-5 text-right bg-slate-50/50 text-slate-800">New Balance</th>
                        <th class="px-8 py-5">Ref / Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($movements as $log)
                    <tr class="hover:bg-indigo-50/10 transition-colors">
                        <td class="px-8 py-5">
                            <span class="text-xs font-bold text-slate-500 italic">{{ $log->created_at->format('d/m/Y') }}</span>
                            <p class="text-[10px] text-slate-400">{{ $log->created_at->format('H:i:s') }}</p>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-indigo-50 text-indigo-500 rounded-full flex items-center justify-center text-[10px] font-black uppercase shadow-sm">
                                    {{ substr($log->user->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-slate-700 tracking-tight">{{ $log->user->name }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter {{ $log->type == 'IN' ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }}">
                                {{ $log->type }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right font-black {{ $log->quantity > 0 ? 'text-emerald-500' : 'text-rose-500' }}">
                            {{ $log->quantity > 0 ? '+' : '' }}{{ number_format($log->quantity, 0) }}
                        </td>
                        <td class="px-8 py-5 text-right font-black bg-slate-50/30 text-slate-800 text-lg">
                            {{ number_format($log->balance_after, 0) }}
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700">{{ $log->reference ?? '-' }}</span>
                                <span class="text-[10px] text-slate-400 italic font-medium leading-none mt-1">{{ $log->note ?? 'No description' }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center text-slate-300 italic">Belum ada riwayat transaksi untuk produk ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 bg-slate-50/30 border-t border-slate-50">
            {{ $movements->links() }}
        </div>
    </div>
</div>
@endsection