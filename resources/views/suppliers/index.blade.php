@extends('layouts.app')

@section('title', 'Supplier Master | ERP Tekstil')
@section('page-title', 'Purchasing & Vendor Management')

@section('content')
<div class="space-y-8 pb-10">
    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                <a href="#" class="hover:text-indigo-600 transition-colors">Master Data</a>
                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                <span class="text-slate-900">Vendor Registry</span>
            </nav>
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Daftar Vendor & Supplier</h2>
            <p class="text-slate-500 font-medium mt-2 max-w-md">Kelola database mitra strategis untuk suplai bahan baku tekstil dan logistik.</p>
        </div>

        <div class="flex items-center gap-3">
            <button class="flex items-center gap-2 px-6 py-3 bg-white border border-slate-100 text-slate-600 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all shadow-sm">
                <i data-lucide="printer" class="w-4 h-4"></i>
                Cetak Alamat
            </button>
            <a href="{{ route('suppliers.create') }}"
                class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
                <i data-lucide="plus" class="w-4 h-4"></i>
                New Supplier
            </a>
        </div>
    </div>

    {{-- Supplier Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all duration-500">
            <div class="w-16 h-16 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-inner">
                <i data-lucide="truck" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Mitra</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter">{{ $suppliers->total() }}</p>
            </div>
        </div>

        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all duration-500">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-500 shadow-inner">
                <i data-lucide="verified" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Active Vendor</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter">{{ $suppliers->where('is_active', true)->count() }}</p>
            </div>
        </div>

        <div class="bg-slate-900 p-7 rounded-[2.5rem] flex items-center gap-6 shadow-2xl shadow-slate-200 relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-24 h-full bg-white/5 skew-x-[20deg] translate-x-8 group-hover:translate-x-0 transition-transform duration-700"></div>
            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center relative z-10 border border-white/10">
                <i data-lucide="info" class="w-6 h-6 text-indigo-400"></i>
            </div>
            <p class="text-[11px] font-bold text-slate-300 leading-relaxed relative z-10">Integrasikan Kode Supplier pada <span class="text-white underline decoration-indigo-500 underline-offset-4">Purchasing Order (PO)</span> untuk pelacakan otomatis.</p>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden group">
        {{-- Search Filter --}}
        <div class="p-8 border-b border-slate-50 bg-slate-50/30">
            <form action="{{ route('suppliers.index') }}" method="GET" class="relative max-w-md">
                <i data-lucide="search" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Supplier atau Contact Person..." 
                    class="w-full pl-14 pr-6 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-bold focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 transition-all outline-none shadow-inner tracking-tight">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-white text-slate-400 uppercase text-[9px] font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-10 py-6 border-b border-slate-50">Identitas Supplier</th>
                        <th class="px-6 py-6 border-b border-slate-50">Contact Person</th>
                        <th class="px-6 py-6 border-b border-slate-50">Kontak & Telepon</th>
                        <th class="px-6 py-6 border-b border-slate-50 text-center">Status</th>
                        <th class="px-10 py-6 border-b border-slate-50 text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($suppliers as $supplier)
                    <tr class="hover:bg-slate-50/80 transition-all group/row">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center font-black text-slate-400 group-hover/row:bg-indigo-600 group-hover/row:text-white group-hover/row:rotate-6 transition-all shadow-sm">
                                    {{ substr($supplier->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900 group-hover/row:text-indigo-600 transition-colors text-sm uppercase italic tracking-tight">{{ $supplier->name }}</span>
                                    <span class="text-[10px] font-black text-slate-400 mt-1 uppercase tracking-[0.15em] flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-200"></span>
                                        CODE: {{ $supplier->code }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-700 uppercase tracking-tighter text-xs">{{ $supplier->contact_person ?? 'N/A' }}</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Authorized Rep.</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center gap-2.5 text-slate-600 font-black text-[11px]">
                                    <div class="w-5 h-5 rounded-lg bg-indigo-50 flex items-center justify-center">
                                        <i data-lucide="phone" class="w-3 h-3 text-indigo-600"></i>
                                    </div>
                                    {{ $supplier->phone ?? '-' }}
                                </div>
                                @if($supplier->email)
                                <div class="flex items-center gap-2.5 text-[10px] text-slate-400 font-bold group-hover/row:text-slate-600 transition-colors">
                                    <div class="w-5 h-5 rounded-lg bg-slate-50 flex items-center justify-center">
                                        <i data-lucide="mail" class="w-3 h-3"></i>
                                    </div>
                                    {{ $supplier->email }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex justify-center">
                                @if($supplier->is_active)
                                <div class="flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black border border-emerald-100 shadow-sm">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    ACTIVE
                                </div>
                                @else
                                <div class="flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-100 text-slate-400 text-[9px] font-black border border-slate-200">
                                    <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                                    IDLE
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end gap-2.5 opacity-0 group-hover/row:opacity-100 transition-all transform translate-x-4 group-hover/row:translate-x-0">
                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                    class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 border border-slate-100 rounded-xl transition-all shadow-sm" title="Edit Partner">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Hapus supplier ini dari database?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 hover:text-rose-600 hover:bg-rose-50 border border-slate-100 rounded-xl transition-all shadow-sm" title="Remove Vendor">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6 border-2 border-dashed border-slate-100">
                                    <i data-lucide="users" class="w-10 h-10"></i>
                                </div>
                                <p class="text-slate-400 font-black uppercase tracking-widest text-xs italic">Database vendor masih kosong...</p>
                                <a href="{{ route('suppliers.create') }}" class="mt-4 text-indigo-600 text-[10px] font-black uppercase hover:underline">Tambah mitra pertama Anda</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($suppliers->hasPages())
        <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-50">
            {{ $suppliers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection