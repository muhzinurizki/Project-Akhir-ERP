@extends('layouts.app')

@section('title', 'Purchase Requests | ERP Tekstil')

@section('content')
<div class="max-w-7xl mx-auto p-8 pb-20">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div class="flex items-center gap-5">
            <div class="p-4 bg-slate-900 rounded-[1.5rem] shadow-xl shadow-slate-200">
                <i data-lucide="shopping-cart" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none mb-2">Purchase Requests</h1>
                <p class="text-slate-400 font-medium">Manajemen pengadaan barang dan approval departemen.</p>
            </div>
        </div>

        <a href="{{ route('purchase-requests.create') }}" class="group flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-2xl font-black hover:bg-slate-800 transition-all shadow-2xl shadow-slate-200 active:scale-95 text-sm uppercase tracking-widest">
            <i data-lucide="plus-circle" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
            Buat PR Baru
        </a>
    </div>

    {{-- Stats Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-1">Total PR</p>
            <h3 class="text-3xl font-black text-slate-900 leading-none">{{ $prs->total() }}</h3>
        </div>
        {{-- Menggunakan total() dari paginator atau count manual jika perlu --}}
        <div class="bg-amber-500 p-7 rounded-[2.5rem] shadow-xl shadow-amber-100 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-amber-100 mb-1">Menunggu Approval</p>
                <h3 class="text-3xl font-black leading-none">{{ $prs->where('status', 'PENDING')->count() }}</h3>
            </div>
            <i data-lucide="clock" class="w-20 h-20 absolute -right-4 -bottom-4 text-white opacity-20"></i>
        </div>
        <div class="bg-emerald-500 p-7 rounded-[2.5rem] shadow-xl shadow-emerald-100 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-100 mb-1">Disetujui</p>
                <h3 class="text-3xl font-black leading-none">{{ $prs->where('status', 'APPROVED')->count() }}</h3>
            </div>
            <i data-lucide="check-circle" class="w-20 h-20 absolute -right-4 -bottom-4 text-white opacity-20"></i>
        </div>
        <div class="bg-indigo-600 p-7 rounded-[2.5rem] shadow-xl shadow-indigo-100 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-100 mb-1">Selesai (PO)</p>
                <h3 class="text-3xl font-black leading-none">{{ $prs->where('status', 'COMPLETED')->count() }}</h3>
            </div>
            <i data-lucide="package-check" class="w-20 h-20 absolute -right-4 -bottom-4 text-white opacity-20"></i>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        {{-- Toolbar/Search --}}
        <div class="p-8 border-b border-slate-50 bg-slate-50/20 flex flex-col md:flex-row justify-between items-center gap-4">
            <form action="{{ route('purchase-requests.index') }}" method="GET" class="relative w-full md:w-96">
                <i data-lucide="search" class="w-5 h-5 absolute left-5 top-1/2 -translate-y-1/2 text-slate-300"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. PR..." class="w-full pl-14 pr-6 py-4 bg-white border-none rounded-2xl text-sm font-bold shadow-sm ring-1 ring-slate-100 focus:ring-2 focus:ring-slate-900 transition-all">
            </form>
            <div class="flex gap-2">
                <button class="p-4 bg-white border border-slate-100 rounded-2xl text-slate-400 hover:text-slate-900 transition-all flex items-center gap-2 font-bold text-xs uppercase tracking-widest">
                    <i data-lucide="filter" class="w-5 h-5"></i> Filter
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-10 py-6">Transaction Detail</th>
                        <th class="px-6 py-6 text-center">Requested By</th>
                        <th class="px-6 py-6 text-center">Status Badge</th>
                        <th class="px-10 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm font-medium">
                    @forelse($prs as $pr)
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-10 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-900 text-lg tracking-tight uppercase group-hover:text-indigo-600 transition-colors">{{ $pr->pr_number }}</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <i data-lucide="calendar" class="w-3 h-3 text-slate-300"></i>
                                    <span class="text-[10px] text-slate-400 font-black uppercase">{{ \Carbon\Carbon::parse($pr->request_date)->format('d F Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center justify-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-xs font-black text-indigo-500 border border-indigo-100 uppercase">
                                    {{ substr($pr->user->name, 0, 2) }}
                                </div>
                                <div class="text-left">
                                    <div class="text-slate-800 font-black tracking-tight leading-none uppercase text-xs">{{ $pr->user->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">{{ $pr->user->department ?? 'Staff' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @php
                                $statusClasses = [
                                    'PENDING' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'APPROVED' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'REJECTED' => 'bg-rose-50 text-rose-600 border-rose-100',
                                    'COMPLETED' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'DRAFT' => 'bg-slate-50 text-slate-600 border-slate-100',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black border uppercase tracking-widest {{ $statusClasses[$pr->status] ?? $statusClasses['DRAFT'] }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current mr-2 {{ $pr->status === 'PENDING' ? 'animate-pulse' : '' }}"></span>
                                {{ $pr->status }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex items-center justify-end gap-3">
                                {{-- Tombol Create PO hanya muncul jika APPROVED --}}
                                @if($pr->status === 'APPROVED')
                                    <a href="{{ route('purchase-orders.create', ['pr_id' => $pr->id]) }}" 
                                       class="flex items-center gap-2 px-5 py-2.5 bg-emerald-500 text-white rounded-xl text-[10px] font-black hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100 uppercase tracking-widest group/btn">
                                        <i data-lucide="file-plus" class="w-3.5 h-3.5 group-hover/btn:scale-110 transition-transform"></i>
                                        Create PO
                                    </a>
                                @endif

                                <a href="{{ route('purchase-requests.show', $pr->id) }}" 
                                   class="inline-flex items-center justify-center w-11 h-11 bg-white border border-slate-100 text-slate-300 rounded-xl hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm hover:shadow-xl hover:-translate-y-1"
                                   title="Lihat Detail">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-6 bg-slate-50 rounded-full mb-4 text-slate-200">
                                    <i data-lucide="file-x" class="w-16 h-16"></i>
                                </div>
                                <h3 class="text-slate-900 font-black uppercase">No Request Found</h3>
                                <p class="text-slate-400 text-sm mt-1 font-medium">Belum ada data permintaan pembelian yang tercatat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($prs->hasPages())
        <div class="p-8 bg-slate-50/50 border-t border-slate-100">
            {{ $prs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection