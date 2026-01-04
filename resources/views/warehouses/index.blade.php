@extends('layouts.app')

@section('title', 'Warehouse Master')
@section('page-title', 'Inventory')

@section('content')
<div class="space-y-8">
  {{-- Header Section --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <a href="#" class="hover:text-slate-900 transition-colors">Inventory</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">Warehouses</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Gudang</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Kelola lokasi penyimpanan bahan baku, kain jadi, dan logistik
        distribusi.</p>
    </div>

    <div class="flex items-center gap-3">
      <a href="{{ route('warehouses.create') }}"
        class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Gudang
      </a>
    </div>
  </div>

  {{-- Warehouse Stats --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
      <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
        <i data-lucide="home" class="w-7 h-7 text-slate-600"></i>
      </div>
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Lokasi</p>
        <p class="text-2xl font-black text-slate-900">{{ $warehouses->total() }}</p>
      </div>
    </div>
    <div
      class="col-span-2 bg-indigo-600 p-6 rounded-[2rem] shadow-xl shadow-indigo-100 flex items-center justify-between overflow-hidden relative">
      <div class="relative z-10">
        <h3 class="text-white font-bold text-lg leading-tight">Optimasi Inventori</h3>
        <p class="text-indigo-100 text-xs mt-1 max-w-xs">Pastikan setiap gudang memiliki PIC yang bertanggung jawab
          untuk akurasi stok fisik (Stock Opname).</p>
      </div>
      <i data-lucide="box" class="w-24 h-24 text-white opacity-10 absolute -right-4 -bottom-4 rotate-12"></i>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-bold tracking-[0.15em]">
          <tr>
            <th class="px-8 py-5">Info Gudang</th>
            <th class="px-6 py-5">Lokasi / Alamat</th>
            <th class="px-6 py-5 text-center">Status</th>
            <th class="px-8 py-5 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($warehouses as $warehouse)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5">
              <div class="flex items-center gap-4">
                <div
                  class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-600 transition-all">
                  <i data-lucide="warehouse" class="w-5 h-5 text-indigo-600 group-hover:text-white"></i>
                </div>
                <div class="flex flex-col">
                  <span class="font-bold text-slate-900 leading-tight">{{ $warehouse->name }}</span>
                  <span class="text-[11px] font-mono font-bold text-indigo-500 uppercase mt-0.5 tracking-tighter">{{
                    $warehouse->code }}</span>
                </div>
              </div>
            </td>
            <td class="px-6 py-5">
              <p class="text-slate-600 font-medium max-w-xs truncate">{{ $warehouse->address ?? 'Alamat belum diatur' }}
              </p>
            </td>
            <td class="px-6 py-5">
              <div class="flex justify-center">
                @if($warehouse->is_active)
                <span
                  class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100">
                  OPERASIONAL
                </span>
                @else
                <span
                  class="px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold border border-rose-100">
                  NON-AKTIF
                </span>
                @endif
              </div>
            </td>
            <td class="px-8 py-5 text-right">
              <div
                class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                <a href="{{ route('warehouses.edit', $warehouse) }}"
                  class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 rounded-xl transition-all shadow-sm">
                  <i data-lucide="edit-3" class="w-4 h-4"></i>
                </a>
                <button
                  class="p-2.5 bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-100 rounded-xl transition-all shadow-sm">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-8 py-20 text-center">
              <div class="flex flex-col items-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                  <i data-lucide="database" class="w-10 h-10 text-slate-200"></i>
                </div>
                <p class="text-slate-400 font-bold">Data gudang tidak ditemukan</p>
                <p class="text-slate-400 text-xs">Mulai dengan menambahkan lokasi gudang pertama Anda.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($warehouses->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
      {{ $warehouses->links() }}
    </div>
    @endif
  </div>
</div>
@endsection