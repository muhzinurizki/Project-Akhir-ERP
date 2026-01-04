@extends('layouts.app')

@section('title', 'Warehouse Master | ERP Tekstil')
@section('page-title', 'Inventory & Logistics')

@section('content')
<div class="space-y-8 pb-10">
    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                <a href="#" class="hover:text-indigo-600 transition-colors">Inventory</a>
                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                <span class="text-slate-900">Warehouse Network</span>
            </nav>
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Manajemen Gudang</h2>
            <p class="text-slate-500 font-medium mt-2 max-w-md italic">Kelola lokasi penyimpanan bahan baku, kain jadi, dan logistik distribusi.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('warehouses.create') }}"
                class="flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-[0.2em] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 group">
                <i data-lucide="plus" class="w-4 h-4 group-hover:rotate-90 transition-transform"></i>
                Tambah Gudang
            </a>
        </div>
    </div>

    {{-- Warehouse Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-6 group hover:shadow-xl transition-all duration-500">
            <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-inner">
                <i data-lucide="home" class="w-8 h-8"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Lokasi</p>
                <p class="text-3xl font-black text-slate-900 tracking-tighter">{{ $warehouses->total() }} <span class="text-sm font-bold text-slate-300 ml-1">Sites</span></p>
            </div>
        </div>

        <div class="col-span-1 md:col-span-2 bg-slate-900 p-7 rounded-[2.5rem] shadow-2xl shadow-slate-200 flex items-center justify-between overflow-hidden relative group">
            {{-- Decorative pattern --}}
            <div class="absolute top-0 right-0 w-48 h-full bg-white/5 skew-x-[25deg] translate-x-20 group-hover:translate-x-10 transition-transform duration-1000"></div>
            
            <div class="relative z-10 flex items-center gap-6">
                <div class="w-14 h-14 rounded-xl bg-indigo-500/20 border border-white/10 flex items-center justify-center">
                    <i data-lucide="shield-check" class="w-7 h-7 text-indigo-400"></i>
                </div>
                <div>
                    <h3 class="text-white font-black text-lg tracking-tight uppercase italic">Optimasi Inventori</h3>
                    <p class="text-slate-400 text-[11px] font-bold mt-1 max-w-sm leading-relaxed uppercase tracking-wider">Pastikan setiap gudang memiliki PIC untuk akurasi stok fisik (Stock Opname).</p>
                </div>
            </div>
            <i data-lucide="box" class="w-32 h-32 text-white/5 absolute -right-4 -bottom-8 rotate-12 group-hover:rotate-0 transition-transform duration-700"></i>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-separate border-spacing-0">
                <thead class="bg-white text-slate-400 uppercase text-[9px] font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-10 py-6 border-b border-slate-50">Info Gudang</th>
                        <th class="px-6 py-6 border-b border-slate-50">Lokasi / Alamat</th>
                        <th class="px-6 py-6 border-b border-slate-50 text-center">Status Operasional</th>
                        <th class="px-10 py-6 border-b border-slate-50 text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($warehouses as $warehouse)
                    <tr class="hover:bg-slate-50/50 transition-all group/row">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover/row:bg-indigo-600 group-hover/row:text-white transition-all shadow-sm">
                                    <i data-lucide="warehouse" class="w-5 h-5 group-hover/row:scale-110 transition-transform"></i>
                                </div>
                                <div class="flex flex-col">
                                    <span class="font-black text-slate-900 uppercase italic tracking-tight group-hover/row:text-indigo-600 transition-colors">{{ $warehouse->name }}</span>
                                    <span class="text-[10px] font-black text-indigo-500 uppercase mt-1 tracking-widest flex items-center gap-1.5">
                                        <span class="w-1 h-1 rounded-full bg-indigo-400"></span>
                                        {{ $warehouse->code }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-slate-500">
                            <div class="flex items-start gap-3 max-w-xs">
                                <i data-lucide="map-pin" class="w-4 h-4 text-slate-300 flex-none mt-0.5"></i>
                                <span class="font-bold text-xs leading-relaxed uppercase tracking-tight">{{ $warehouse->address ?? 'Lokasi belum didefinisikan secara spesifik' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex justify-center">
                                @if($warehouse->is_active)
                                <div class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-[9px] font-black border border-emerald-100 flex items-center gap-2 shadow-sm">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    OPERASIONAL
                                </div>
                                @else
                                <div class="px-4 py-1.5 rounded-full bg-rose-50 text-rose-600 text-[9px] font-black border border-rose-100 flex items-center gap-2 shadow-sm italic">
                                    <i data-lucide="slash" class="w-3 h-3"></i>
                                    NON-AKTIF
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end gap-2.5 opacity-0 group-hover/row:opacity-100 transition-all transform translate-x-4 group-hover/row:translate-x-0">
                                <a href="{{ route('warehouses.edit', $warehouse) }}"
                                    class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 hover:text-indigo-600 border border-slate-100 rounded-xl transition-all shadow-sm hover:border-indigo-100" title="Edit Lokasi">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('warehouses.destroy', $warehouse) }}" method="POST" onsubmit="return confirm('Hapus gudang ini? Tindakan ini dapat memengaruhi relasi stok.')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-10 h-10 flex items-center justify-center bg-white text-slate-400 hover:text-rose-600 border border-slate-100 rounded-xl transition-all shadow-sm hover:border-rose-100" title="Hapus Lokasi">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6 border-2 border-dashed border-slate-100">
                                    <i data-lucide="database" class="w-10 h-10"></i>
                                </div>
                                <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-xs italic">Data gudang tidak ditemukan...</p>
                                <a href="{{ route('warehouses.create') }}" class="mt-4 text-indigo-600 text-[10px] font-black uppercase hover:underline tracking-widest">Daftarkan Lokasi Pertama</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($warehouses->hasPages())
        <div class="px-10 py-8 border-t border-slate-50 bg-slate-50/30">
            {{ $warehouses->links() }}
        </div>
        @endif
    </div>
</div>
@endsection