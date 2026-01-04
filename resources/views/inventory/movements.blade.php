@extends('layouts.app')

@section('title', 'Audit Log Mutasi Stok | Inventory System')

@section('content')
<div class="max-w-7xl mx-auto p-8 pb-20">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-slate-900 rounded-2xl shadow-lg shadow-slate-200">
                <i data-lucide="activity" class="w-7 h-7 text-white"></i>
            </div>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Stock Movements</h1>
                <p class="text-slate-500 font-medium">Log kronologis mutasi barang untuk keperluan audit persediaan.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition-all flex items-center shadow-sm">
                <i data-lucide="filter" class="w-4 h-4 mr-2"></i> Filter Log
            </button>
            <a href="{{ route('inventory.index') }}" class="px-6 py-3 bg-white border border-slate-900 text-slate-900 rounded-2xl font-black hover:bg-slate-900 hover:text-white transition-all flex items-center active:scale-95">
                <i data-lucide="arrow-left" class="w-5 h-5 mr-2"></i>
                Kembali ke Saldo
            </a>
        </div>
    </div>

    {{-- Info Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10 text-white">
    {{-- Inbound Card --}}
    <div class="bg-emerald-600 p-8 rounded-[2.5rem] shadow-xl shadow-emerald-100 flex items-center justify-between overflow-hidden relative">
        <div class="relative z-10">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-200 mb-2">Total Inbound (Bulan Ini)</p>
            <h3 class="text-3xl font-black">+ {{ number_format($totalIn ?? 0, 0) }} Unit</h3>
        </div>
        <i data-lucide="trending-up" class="w-20 h-20 absolute -right-4 -bottom-4 text-emerald-500 opacity-30"></i>
    </div>

    {{-- Outbound Card --}}
    <div class="bg-rose-600 p-8 rounded-[2.5rem] shadow-xl shadow-rose-100 flex items-center justify-between overflow-hidden relative">
        <div class="relative z-10">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-200 mb-2">Total Outbound (Bulan Ini)</p>
            <h3 class="text-3xl font-black">- {{ number_format($totalOut ?? 0, 0) }} Unit</h3>
        </div>
        <i data-lucide="trending-down" class="w-20 h-20 absolute -right-4 -bottom-4 text-rose-500 opacity-30"></i>
    </div>
</div>

    {{-- Audit Log Table --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Waktu & Produk</th>
                        <th class="px-6 py-5">Gudang</th>
                        <th class="px-6 py-5">Jenis Transaksi</th>
                        <th class="px-6 py-5 text-right">Perubahan</th>
                        <th class="px-8 py-5 text-right">Saldo (Awal → Akhir)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm font-medium">
                    @forelse($movements as $m)
                    <tr class="hover:bg-slate-50/50 transition-all">
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-[11px] text-slate-400 font-bold mb-1">{{ $m->created_at->format('d M Y • H:i') }}</span>
                                <span class="text-slate-800 font-black uppercase tracking-tight">{{ $m->item->name ?? 'Deleted Item' }}</span>
                                <span class="text-[10px] font-mono text-slate-400">{{ $m->item->code ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2 text-slate-600 font-bold">
                                <i data-lucide="warehouse" class="w-4 h-4 text-slate-300"></i>
                                {{ $m->warehouse->name ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($m->mutation_type === 'IN')
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black border border-emerald-100">
                                    <i data-lucide="arrow-down-left" class="w-3 h-3 mr-1"></i> STOCK IN
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-black border border-rose-100">
                                    <i data-lucide="arrow-up-right" class="w-3 h-3 mr-1"></i> STOCK OUT
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <div class="text-lg font-black {{ $m->mutation_type === 'IN' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $m->mutation_type === 'IN' ? '+' : '-' }}{{ number_format($m->qty, 0) }}
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex flex-col items-end">
                                <div class="text-xs text-slate-400 line-through decoration-slate-300 decoration-1">
                                    {{ number_format($m->balance_before, 0) }}
                                </div>
                                <div class="text-base font-black text-slate-900">
                                    {{ number_format($m->balance_after, 0) }}
                                    <span class="text-[10px] text-slate-400 ml-1">UNIT</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-4 bg-slate-50 rounded-full mb-4">
                                    <i data-lucide="ghost" class="w-12 h-12 text-slate-200"></i>
                                </div>
                                <p class="text-slate-400 font-bold tracking-tight">Tidak ditemukan riwayat mutasi barang.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($movements->hasPages())
        <div class="p-8 bg-slate-50/50 border-t border-slate-100">
            {{ $movements->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection