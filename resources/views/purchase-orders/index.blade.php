@extends('layouts.app')

@section('title', 'Purchase Order')
@section('page-title', 'Procurement')

@section('content')
<div class="space-y-8">
  {{-- Header Section --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <i data-lucide="shopping-bag" class="w-3 h-3"></i>
        <span>Procurement</span>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">Purchase Order</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pesanan Pembelian (PO)</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Kelola pesanan resmi ke supplier dan pantau status pengiriman.
      </p>
    </div>

    <a href="{{ route('purchase-orders.create') }}"
      class="flex items-center gap-2 px-6 py-3.5 bg-indigo-600 text-white rounded-2xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100">
      <i data-lucide="plus-square" class="w-4.5 h-4.5"></i>
      Buat PO Baru
    </a>
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left border-separate border-spacing-0">
        <thead class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-bold tracking-[0.15em]">
          <tr>
            <th class="px-8 py-5">Nomor PO</th>
            <th class="px-6 py-5">Supplier</th>
            <th class="px-6 py-5">Tanggal Order</th>
            <th class="px-6 py-5 text-center">Status</th>
            <th class="px-8 py-5 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($pos as $po)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5">
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                  <i data-lucide="shopping-cart" class="w-5 h-5 text-slate-400 group-hover:text-white"></i>
                </div>
                <span class="font-black text-slate-900 tracking-tight">{{ $po->po_number }}</span>
              </div>
            </td>
            <td class="px-6 py-5">
              <div class="flex flex-col">
                <span class="font-bold text-slate-700">{{ $po->supplier->name }}</span>
                <span class="text-[11px] text-slate-400 font-medium uppercase tracking-wider">Vendor Resmi</span>
              </div>
            </td>
            <td class="px-6 py-5">
              <span class="font-bold text-slate-600">{{ $po->created_at->format('d M Y') }}</span>
            </td>
            <td class="px-6 py-5 text-center">
              @php
              $statusClasses = [
              'DRAFT' => 'bg-slate-100 text-slate-500 border-slate-200',
              'SENT' => 'bg-blue-50 text-blue-600 border-blue-100',
              'RECEIVED' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
              'CANCELLED' => 'bg-rose-50 text-rose-600 border-rose-100',
              ];
              $class = $statusClasses[$po->status] ?? $statusClasses['DRAFT'];
              @endphp
              <span
                class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border {{ $class }} tracking-tighter">
                {{ $po->status }}
              </span>
            </td>
            <td class="px-8 py-5 text-right">
              <a href="{{ route('purchase-orders.show', $po) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:border-slate-900 hover:text-slate-900 transition-all">
                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                Detail
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-8 py-20 text-center">
              <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                  <i data-lucide="package-search" class="w-8 h-8 text-slate-200"></i>
                </div>
                <p class="text-slate-400 font-bold">Belum ada Purchase Order</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($pos->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
      {{ $pos->links() }}
    </div>
    @endif
  </div>
</div>
@endsection