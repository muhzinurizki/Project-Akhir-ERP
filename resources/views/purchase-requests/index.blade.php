@extends('layouts.app')

@section('title', 'Purchase Request')
@section('page-title', 'Procurement')

@section('content')
<div class="space-y-8">
  {{-- Header Section --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <i data-lucide="shopping-cart" class="w-3 h-3"></i>
        <span>Procurement</span>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">Purchase Request</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Daftar Pengajuan (PR)</h2>
      <p class="text-sm text-slate-500 font-medium mt-1">Manajemen permintaan pembelian barang dan material produksi.
      </p>
    </div>

    <a href="{{ route('purchase-requests.create') }}"
      class="flex items-center gap-2 px-6 py-3.5 bg-slate-900 text-white rounded-2xl text-sm font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-200">
      <i data-lucide="plus-circle" class="w-4.5 h-4.5 text-indigo-400"></i>
      Buat PR Baru
    </a>
  </div>

  {{-- Stats Overview (Optional) --}}
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    @php
    $stats = [
    ['label' => 'Total PR', 'count' => $prs->total(), 'color' => 'slate'],
    ['label' => 'Pending', 'count' => '?', 'color' => 'amber'],
    ['label' => 'Approved', 'count' => '?', 'color' => 'emerald'],
    ['label' => 'Rejected', 'count' => '?', 'color' => 'rose'],
    ];
    @endphp
    @foreach($stats as $stat)
    <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm">
      <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $stat['label'] }}</p>
      <p class="text-2xl font-black text-slate-900 mt-1">{{ $stat['count'] }}</p>
    </div>
    @endforeach
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left border-separate border-spacing-0">
        <thead class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-bold tracking-[0.15em]">
          <tr>
            <th class="px-8 py-5">No. Pengajuan</th>
            <th class="px-6 py-5">Tanggal & Gudang</th>
            <th class="px-6 py-5">Pemohon</th>
            <th class="px-6 py-5 text-center">Status</th>
            <th class="px-8 py-5 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($prs as $pr)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5">
              <div class="flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white shadow-lg shadow-slate-200">
                  <i data-lucide="file-text" class="w-5 h-5 text-indigo-400"></i>
                </div>
                <span class="font-black text-slate-900 tracking-tight">{{ $pr->pr_number }}</span>
              </div>
            </td>
            <td class="px-6 py-5">
              <div class="flex flex-col">
                <span class="font-bold text-slate-700">{{ $pr->request_date->format('d M Y') }}</span>
                <span class="text-[11px] text-slate-400 font-medium flex items-center gap-1">
                  <i data-lucide="map-pin" class="w-3 h-3"></i> {{ $pr->warehouse->name }}
                </span>
              </div>
            </td>
            <td class="px-6 py-5">
              <div class="flex items-center gap-2">
                <div
                  class="w-7 h-7 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-500 border border-slate-200 uppercase">
                  {{ substr($pr->requester->name, 0, 2) }}
                </div>
                <span class="font-bold text-slate-600">{{ $pr->requester->name }}</span>
              </div>
            </td>
            <td class="px-6 py-5 text-center">
              @php
              $statusClasses = [
              'DRAFT' => 'bg-slate-100 text-slate-500 border-slate-200',
              'SUBMITTED' => 'bg-amber-50 text-amber-600 border-amber-100',
              'APPROVED' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
              'REJECTED' => 'bg-rose-50 text-rose-600 border-rose-100',
              ];
              $class = $statusClasses[$pr->status] ?? $statusClasses['DRAFT'];
              @endphp
              <span
                class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black border {{ $class }} tracking-tighter">
                {{ $pr->status }}
              </span>
            </td>
            <td class="px-8 py-5 text-right">
              <a href="{{ route('purchase-requests.show', $pr) }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:border-slate-900 hover:text-slate-900 transition-all shadow-sm">
                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                Detail
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-8 py-20 text-center">
              <div class="flex flex-col items-center">
                <i data-lucide="file-question" class="w-12 h-12 text-slate-200 mb-4"></i>
                <p class="text-slate-400 font-bold">Tidak ada data Purchase Request</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($prs->hasPages())
    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
      {{ $prs->links() }}
    </div>
    @endif
  </div>
</div>
@endsection