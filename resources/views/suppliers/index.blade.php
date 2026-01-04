@extends('layouts.app')

@section('title', 'Supplier Master')
@section('page-title', 'Purchasing')

@section('content')
<div class="space-y-8">
  {{-- Header Section --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <a href="#" class="hover:text-slate-900 transition-colors">Master Data</a>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">Suppliers</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Vendor & Supplier</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Kelola data mitra penyedia bahan baku dan jasa pihak ketiga.
      </p>
    </div>

    <div class="flex items-center gap-3">
      <button
        class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-bold hover:bg-slate-50 transition-all shadow-sm">
        <i data-lucide="printer" class="w-4 h-4 text-slate-400"></i>
        Cetak Alamat
      </button>
      <a href="{{ route('suppliers.create') }}"
        class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Tambah Supplier
      </a>
    </div>
  </div>

  {{-- Supplier Quick Stats --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
      <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center">
        <i data-lucide="truck" class="w-7 h-7 text-indigo-600"></i>
      </div>
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Mitra</p>
        <p class="text-2xl font-black text-slate-900">{{ $suppliers->total() }}</p>
      </div>
    </div>
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5">
      <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center">
        <i data-lucide="check-circle" class="w-7 h-7 text-emerald-600"></i>
      </div>
      <div>
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Supplier Aktif</p>
        <p class="text-2xl font-black text-slate-900">{{ $suppliers->where('is_active', true)->count() }}</p>
      </div>
    </div>
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-5 text-indigo-600">
      <i data-lucide="info" class="w-5 h-5 opacity-50"></i>
      <p class="text-xs font-semibold leading-relaxed">Pastikan kode supplier unik untuk memudahkan integrasi pada modul
        Purchase Order (PO).</p>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-bold tracking-[0.15em]">
          <tr>
            <th class="px-8 py-5">Identitas Supplier</th>
            <th class="px-6 py-5">Contact Person</th>
            <th class="px-6 py-5">Kontak & Telepon</th>
            <th class="px-6 py-5 text-center">Status</th>
            <th class="px-8 py-5 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($suppliers as $supplier)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5">
              <div class="flex items-center gap-4">
                <div
                  class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                  {{ substr($supplier->name, 0, 1) }}
                </div>
                <div class="flex flex-col">
                  <span class="font-bold text-slate-900 leading-tight">{{ $supplier->name }}</span>
                  <span class="text-[11px] font-mono font-bold text-slate-400 uppercase mt-0.5">{{ $supplier->code
                    }}</span>
                </div>
              </div>
            </td>
            <td class="px-6 py-5">
              <div class="flex flex-col">
                <span class="font-semibold text-slate-700">{{ $supplier->contact_person ?? 'N/A' }}</span>
                <span class="text-[11px] text-slate-400">Representative</span>
              </div>
            </td>
            <td class="px-6 py-5">
              <div class="flex flex-col gap-1">
                <div class="flex items-center gap-2 text-slate-600 font-medium">
                  <i data-lucide="phone" class="w-3 h-3 text-slate-300"></i>
                  {{ $supplier->phone ?? '-' }}
                </div>
                @if($supplier->email)
                <div class="flex items-center gap-2 text-xs text-slate-400">
                  <i data-lucide="mail" class="w-3 h-3"></i>
                  {{ $supplier->email }}
                </div>
                @endif
              </div>
            </td>
            <td class="px-6 py-5">
              <div class="flex justify-center">
                @if($supplier->is_active)
                <span
                  class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold border border-emerald-100">
                  ACTIVE
                </span>
                @else
                <span
                  class="px-3 py-1 rounded-full bg-slate-50 text-slate-400 text-[10px] font-bold border border-slate-100">
                  INACTIVE
                </span>
                @endif
              </div>
            </td>
            <td class="px-8 py-5 text-right">
              <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <a href="{{ route('suppliers.edit', $supplier) }}"
                  class="p-2 bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 rounded-xl transition-all shadow-sm">
                  <i data-lucide="edit-3" class="w-4 h-4"></i>
                </a>
                <button
                  class="p-2 bg-white border border-slate-200 text-slate-400 hover:text-rose-600 hover:border-rose-100 rounded-xl transition-all shadow-sm">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-8 py-20 text-center text-slate-400">
              <i data-lucide="users" class="w-12 h-12 mx-auto mb-4 opacity-20"></i>
              <p class="font-bold">Belum ada data supplier.</p>
              <p class="text-xs">Klik "+ Tambah Supplier" untuk memulai.</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($suppliers->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
      {{ $suppliers->links() }}
    </div>
    @endif
  </div>
</div>
@endsection