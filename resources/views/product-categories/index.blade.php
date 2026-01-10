@extends('layouts.app')

@section('title', 'Kategori Produk | ERP Tekstil')
@section('page-title', 'Kategori Produk')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Kategori Produk</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Kelola klasifikasi utama untuk bahan baku dan barang jadi.</p>
        </div>
        
        <a href="{{ route('product-categories.create') }}" 
           class="group flex items-center gap-4 bg-slate-900 text-white px-8 py-4 rounded-2xl hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 active:scale-95">
            <div class="flex flex-col items-end">
                <span class="text-[10px] font-black uppercase tracking-widest opacity-60">Tambah Baru</span>
                <span class="text-sm font-black uppercase italic">Kategori</span>
            </div>
            <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center group-hover:rotate-90 transition-transform">
                <i data-lucide="plus" class="w-5 h-5"></i>
            </div>
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600">
                <i data-lucide="layers" class="w-7 h-7"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Total Kategori</p>
                <p class="text-2xl font-black text-slate-900">{{ $categories->count() }}</p>
            </div>
        </div>
        </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">Kode Klasifikasi</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50">Nama Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50 text-center">Produk Terkait</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-50 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($categories as $category)
                    <tr class="group hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 bg-slate-900 text-white text-[10px] font-black rounded-lg shadow-lg shadow-slate-200 uppercase tracking-tighter">
                                {{ $category->code }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ $category->name }}</p>
                            <p class="text-[10px] text-slate-400 font-medium italic mt-0.5 line-clamp-1">
                                {{ $category->description ?? 'Tidak ada deskripsi' }}
                            </p>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="text-xs font-black bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full">
                                {{ $category->products_count ?? 0 }} SKU
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('product-categories.edit', $category) }}" 
                                   class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:border-indigo-600 hover:text-indigo-600 hover:shadow-lg hover:shadow-indigo-100 transition-all">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                
                                <form action="{{ route('product-categories.destroy', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus kategori ini?')"
                                            class="w-9 h-9 flex items-center justify-center rounded-xl bg-white border border-slate-100 text-slate-400 hover:border-rose-600 hover:text-rose-600 hover:shadow-lg hover:shadow-rose-100 transition-all">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4">
                                    <i data-lucide="layers" class="w-10 h-10 text-slate-200"></i>
                                </div>
                                <p class="text-sm font-black text-slate-400 uppercase tracking-widest">Belum ada data kategori</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection