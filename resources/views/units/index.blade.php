@extends('layouts.app')

@section('title', 'Satuan Produk | ERP Tekstil')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Satuan / UoM</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Unit of Measurement untuk standarisasi stok kain dan aksesoris.</p>
        </div>
        
        <a href="{{ route('units.create') }}" 
           class="group flex items-center gap-4 bg-slate-900 text-white px-8 py-4 rounded-2xl hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200">
            <span class="text-sm font-black uppercase italic text-right">Tambah<br><span class="opacity-50 text-[10px]">Satuan</span></span>
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover:rotate-90 transition-transform">
                <i data-lucide="plus" class="w-5 h-5"></i>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl overflow-hidden">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kode</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Satuan</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Penggunaan</th>
                    <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($units as $unit)
                <tr class="group hover:bg-slate-50/30 transition-all">
                    <td class="px-8 py-6">
                        <span class="px-4 py-2 bg-indigo-50 text-indigo-600 text-[11px] font-black rounded-xl border border-indigo-100">
                            {{ $unit->code }}
                        </span>
                    </td>
                    <td class="px-8 py-6 text-sm font-black text-slate-900 uppercase">{{ $unit->name }}</td>
                    <td class="px-8 py-6 text-center">
                        <span class="text-xs font-bold text-slate-400">{{ $unit->products_count }} Produk</span>
                    </td>
                    <td class="px-8 py-6">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('units.edit', $unit) }}" class="p-2.5 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-600 transition-all shadow-sm">
                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                            </a>
                            <form action="{{ route('units.destroy', $unit) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus satuan ini?')" class="p-2.5 bg-white border border-slate-100 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-600 transition-all shadow-sm">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection