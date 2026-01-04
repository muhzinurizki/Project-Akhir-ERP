@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Procurement Audit')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
  {{-- Navigation & Actions --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('purchase-requests.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar
    </a>

    <div class="flex items-center gap-3">
      @if($purchaseRequest->status === 'APPROVED')
      <button
        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
        <i data-lucide="printer" class="w-4 h-4"></i> Cetak PDF
      </button>
      @endif
    </div>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Detail --}}
    <div
      class="px-10 py-10 border-b border-slate-50 bg-slate-50/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
      <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
          <span
            class="text-[10px] font-black bg-slate-900 text-white px-3 py-1 rounded-full tracking-widest uppercase">Dokumen
            Internal</span>
          <span class="text-slate-400 text-xs font-bold">{{ $purchaseRequest->request_date->format('d M Y') }}</span>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight uppercase">{{ $purchaseRequest->pr_number }}
        </h2>
      </div>

      @php
      $statusMap = [
      'DRAFT' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-500', 'icon' => 'edit-3'],
      'SUBMITTED' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'icon' => 'send'],
      'APPROVED' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'check-circle'],
      'REJECTED' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-600', 'icon' => 'x-circle'],
      ];
      $curr = $statusMap[$purchaseRequest->status] ?? $statusMap['DRAFT'];
      @endphp

      <div
        class="flex items-center gap-4 px-6 py-4 rounded-[2rem] {{ $curr['bg'] }} border border-white shadow-inner relative z-10">
        <i data-lucide="{{ $curr['icon'] }}" class="w-6 h-6 {{ $curr['text'] }}"></i>
        <div class="flex flex-col">
          <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 opacity-60">Status Saat
            Ini</span>
          <span class="text-sm font-black {{ $curr['text'] }} tracking-tight">{{ $purchaseRequest->status }}</span>
        </div>
      </div>

      <i data-lucide="file-text"
        class="w-40 h-40 text-slate-200 opacity-20 absolute -right-10 -bottom-10 rotate-12"></i>
    </div>

    <div class="p-10">
      {{-- Info Cards --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100 flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center">
            <i data-lucide="warehouse" class="w-6 h-6 text-indigo-500"></i>
          </div>
          <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Gudang Tujuan</p>
            <p class="text-sm font-bold text-slate-900">{{ $purchaseRequest->warehouse->name }}</p>
          </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100 flex items-center gap-4">
          <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center">
            <i data-lucide="user" class="w-6 h-6 text-indigo-500"></i>
          </div>
          <div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Diajukan Oleh</p>
            <p class="text-sm font-bold text-slate-900">{{ $purchaseRequest->requester->name }}</p>
          </div>
        </div>
      </div>

      {{-- Items Table --}}
      <div class="space-y-4 mb-10">
        <div class="flex items-center gap-3">
          <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Rincian Barang</h3>
          <div class="h-px flex-1 bg-slate-100"></div>
        </div>

        <div class="border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
          <table class="w-full text-sm text-left border-separate border-spacing-0">
            <thead class="bg-slate-50/80 text-slate-400 uppercase text-[10px] font-black tracking-widest">
              <tr>
                <th class="px-8 py-4">Item Produk</th>
                <th class="px-6 py-4 text-center">Kuantitas</th>
                <th class="px-8 py-4">Catatan Khusus</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
              @foreach($purchaseRequest->items as $item)
              <tr class="group transition-all">
                <td class="px-8 py-5">
                  <span class="font-bold text-slate-900">{{ $item->product->name }}</span>
                </td>
                <td class="px-6 py-5 text-center">
                  <span class="px-4 py-1.5 rounded-lg bg-slate-100 font-black text-slate-900">
                    {{ number_format($item->quantity, 4) }}
                  </span>
                </td>
                <td class="px-8 py-5">
                  <span class="text-slate-500 font-medium italic">{{ $item->note ?? '-' }}</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- Action Workflows --}}
      <div class="pt-10 border-t border-slate-50 flex flex-wrap items-center justify-between gap-6">
        <div class="text-sm text-slate-400 font-medium italic">
          <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
          Tindakan pada dokumen ini akan tercatat dalam log audit sistem.
        </div>

        <div class="flex items-center gap-3">
          @if($purchaseRequest->status === 'DRAFT')
          <form method="POST" action="{{ route('purchase-requests.submit', $purchaseRequest) }}">
            @csrf
            <button
              class="px-8 py-4 bg-amber-500 text-white text-sm font-bold rounded-2xl hover:bg-amber-600 shadow-xl shadow-amber-100 transition-all flex items-center gap-2">
              <i data-lucide="send" class="w-4 h-4 text-white"></i> Submit Pengajuan
            </button>
          </form>
          @endif

          @if($purchaseRequest->status === 'SUBMITTED')
          <form method="POST" action="{{ route('purchase-requests.reject', $purchaseRequest) }}">
            @csrf
            <button
              class="px-8 py-4 text-rose-600 text-sm font-bold rounded-2xl hover:bg-rose-50 transition-all border border-rose-100">
              Reject Pengajuan
            </button>
          </form>

          <form method="POST" action="{{ route('purchase-requests.approve', $purchaseRequest) }}">
            @csrf
            <button
              class="px-10 py-4 bg-emerald-600 text-white text-sm font-bold rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-100 transition-all flex items-center gap-2">
              <i data-lucide="check-circle" class="w-4 h-4 text-white"></i> Approve Sekarang
            </button>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection