@extends('layouts.app')

@section('title', 'Detail PR: ' . $pr->pr_number)

@section('content')
<div class="max-w-7xl mx-auto p-8 pb-20">

    {{-- Header Navigation --}}
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('purchase-requests.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-slate-900 transition-colors font-bold text-sm">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar
        </a>
        <div class="flex items-center gap-3">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Status Dokumen:</span>
            @php
                $statusColors = [
                    'PENDING' => 'bg-amber-100 text-amber-700 border-amber-200',
                    'APPROVED' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'REJECTED' => 'bg-rose-100 text-rose-700 border-rose-200',
                ];
                $color = $statusColors[$pr->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
            @endphp
            <span class="px-4 py-1 rounded-full border text-[10px] font-black uppercase tracking-tighter {{ $color }}">
                {{ $pr->status }}
            </span>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- Kolom Kiri: Informasi Utama (4 Cols) --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-black text-slate-900 leading-tight uppercase tracking-tighter">{{ $pr->pr_number }}</h1>
                    <p class="text-slate-400 text-xs font-bold mt-1 uppercase tracking-widest">Dibuat pada {{ \Carbon\Carbon::parse($pr->request_date)->format('d M Y') }}</p>
                </div>

                <div class="space-y-6 border-t border-slate-100 pt-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pemohon</label>
                        <div class="flex items-center gap-3 mt-2">
                            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs font-black">
                                {{ substr($pr->user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900">{{ $pr->user->name }}</p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase">{{ $pr->user->department ?? 'Staff' }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Catatan</label>
                        <p class="text-sm text-slate-600 leading-relaxed font-medium bg-slate-50 p-4 rounded-2xl mt-2 border border-slate-100 italic">
                            "{{ $pr->note ?? 'Tidak ada catatan tambahan.' }}"
                        </p>
                    </div>
                </div>
            </div>

            {{-- Action Buttons (Hanya jika PENDING) --}}
            @if($pr->status === 'PENDING')
            <div class="bg-slate-900 rounded-[2rem] p-8 shadow-xl shadow-slate-200">
                <h3 class="text-white text-xs font-black uppercase tracking-widest mb-6">Butuh Persetujuan?</h3>
                <div class="grid grid-cols-1 gap-3">
                    <form action="{{ route('purchase-requests.update-status', $pr->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="APPROVED">
                        <button type="submit" class="w-full py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all active:scale-95 shadow-lg shadow-emerald-900/20">
                            Setujui Request
                        </button>
                    </form>

                    <form action="{{ route('purchase-requests.update-status', $pr->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="REJECTED">
                        <button type="submit" class="w-full py-4 bg-slate-800 hover:bg-rose-600 text-slate-400 hover:text-white rounded-2xl font-black text-xs uppercase tracking-widest transition-all">
                            Tolak Permintaan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        {{-- Kolom Kanan: Daftar Item (8 Cols) --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Detail Item Barang</h3>
                    <span class="text-[10px] font-black text-slate-400 uppercase">{{ $pr->items->count() }} Baris Data</span>
                </div>

                <table class="w-full">
                    <thead>
                        <tr class="bg-white border-b border-slate-100">
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-left">Deskripsi Produk</th>
                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($pr->items as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-slate-100 rounded-xl">
                                        <i data-lucide="package" class="w-5 h-5 text-slate-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $item->product->name }}</p>
                                        <p class="text-[10px] font-mono font-bold text-slate-400 mt-0.5">{{ $item->product->code }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-lg font-black text-slate-900 tracking-tighter">{{ number_format($item->quantity ?? $item->qty, 0) }}</span>
                                <span class="text-[10px] font-black text-slate-400 uppercase ml-1">{{ $item->unit_name ?? 'Unit' }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Summary Footer --}}
                <div class="px-8 py-10 bg-slate-50 border-t border-slate-100">
                    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                        <div class="flex items-center gap-3">
                            <i data-lucide="info" class="w-5 h-5 text-slate-300"></i>
                            <p class="text-xs font-medium text-slate-500 max-w-xs">
                                Dokumen ini dihasilkan secara otomatis oleh sistem ERP dan berlaku sebagai bukti permintaan resmi.
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Verifikasi Digital</p>
                            <p class="text-sm font-black text-slate-900 mt-1 uppercase tracking-tighter">System Verified ✅</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection