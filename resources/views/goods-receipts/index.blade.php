@extends('layouts.app')

@section('title', 'Penerimaan Barang')
@section('page-title', 'Logistics')

@section('content')
<div class="space-y-8">
  {{-- Header Section --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <i data-lucide="package-check" class="w-3 h-3"></i>
        <span>Inventory Control</span>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">Goods Receipt</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Penerimaan Barang (GR)</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Konfirmasi kedatangan material dan update saldo stok gudang
        secara otomatis.</p>
    </div>

    <a href="{{ route('goods-receipts.create') }}"
      class="flex items-center gap-2 px-6 py-3.5 bg-emerald-600 text-white rounded-2xl text-sm font-bold hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-100">
      <i data-lucide="plus-circle" class="w-4.5 h-4.5"></i>
      Input Penerimaan (GR)
    </a>
  </div>

  {{-- Stats Overview (Mini) --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
    <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
      <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
        <i data-lucide="truck" class="w-5 h-5"></i>
      </div>
      <div>
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Total Penerimaan
        </p>
        <p class="text-lg font-black text-slate-900">{{ $receipts->total() }} Dokumen</p>
      </div>
    </div>
    {{-- Anda bisa menambahkan metrik lain di sini --}}
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left border-separate border-spacing-0">
        <thead class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-black tracking-[0.15em]">
          <tr>
            <th class="px-8 py-5">No. Penerimaan</th>
            <th class="px-6 py-5 text-center">Tgl Kedatangan</th>
            <th class="px-6 py-5">Ref. PO Number</th>
            <th class="px-6 py-5">Gudang Penyimpanan</th>
            <th class="px-6 py-5">Petugas (Penerima)</th>
            <th class="px-8 py-5 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($receipts as $gr)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5">
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all shadow-sm">
                  <i data-lucide="archive" class="w-5 h-5 text-slate-400 group-hover:text-white"></i>
                </div>
                <span class="font-black text-slate-900 tracking-tight">{{ $gr->gr_number }}</span>
              </div>
            </td>
            <td class="px-6 py-5 text-center">
              <span class="px-3 py-1.5 rounded-lg bg-slate-100 font-bold text-slate-600 text-xs">
                {{ $gr->gr_date->format('d M Y') }}
              </span>
            </td>
            <td class="px-6 py-5">
              <div class="flex items-center gap-2">
                <i data-lucide="shopping-bag" class="w-3.5 h-3.5 text-indigo-500"></i>
                <span class="font-bold text-slate-700 underline decoration-indigo-100">{{ $gr->purchaseOrder->po_number
                  }}</span>
              </div>
            </td>
            <td class="px-6 py-5">
              <span class="font-bold text-slate-600">{{ $gr->warehouse->name }}</span>
            </td>
            <td class="px-6 py-5">
              <div class="flex items-center gap-2">
                <div
                  class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-black text-slate-500 uppercase">
                  {{ substr($gr->receiver->name, 0, 1) }}
                </div>
                <span class="font-medium text-slate-600">{{ $gr->receiver->name }}</span>
              </div>
            </td>
            <td class="px-8 py-5 text-right">
              <a href="{{ route('goods-receipts.show', $gr) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:border-slate-900 hover:text-slate-900 transition-all shadow-sm">
                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                Review
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-8 py-20 text-center">
              <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                  <i data-lucide="box" class="w-8 h-8 text-slate-200"></i>
                </div>
                <p class="text-slate-400 font-bold tracking-tight">Belum ada catatan kedatangan barang.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($receipts->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
      {{ $receipts->links() }}
    </div>
    @endif
  </div>
</div>



@endsection