@extends('layouts.app')

@section('title', 'Detail Pesanan Pembelian')
@section('page-title', 'Procurement Audit')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
  {{-- Top Action Bar --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('purchase-orders.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar PO
    </a>

    <div class="flex items-center gap-3">
      <button
        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
        <i data-lucide="printer" class="w-4 h-4"></i> Cetak PDF
      </button>
    </div>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Detail --}}
    <div
      class="px-10 py-10 border-b border-slate-50 bg-slate-50/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
      <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
          <span
            class="text-[10px] font-black bg-indigo-600 text-white px-3 py-1 rounded-full tracking-widest uppercase shadow-lg shadow-indigo-100">Pesanan
            Resmi</span>
          <span class="text-slate-400 text-xs font-bold">{{ $purchaseOrder->po_date->format('d M Y') }}</span>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight uppercase">{{ $purchaseOrder->po_number }}</h2>
      </div>

      @php
      $statusMap = [
      'DRAFT' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-500', 'icon' => 'edit-3'],
      'SUBMITTED' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'icon' => 'clock'],
      'APPROVED' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'icon' => 'check-circle'],
      'CLOSED' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-600', 'icon' => 'lock'],
      ];
      $curr = $statusMap[$purchaseOrder->status] ?? $statusMap['DRAFT'];
      @endphp

      <div
        class="flex items-center gap-4 px-6 py-4 rounded-[2rem] {{ $curr['bg'] }} border border-white shadow-inner relative z-10">
        <i data-lucide="{{ $curr['icon'] }}" class="w-6 h-6 {{ $curr['text'] }}"></i>
        <div class="flex flex-col">
          <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 opacity-60">Status PO</span>
          <span class="text-sm font-black {{ $curr['text'] }} tracking-tight">{{ $purchaseOrder->status }}</span>
        </div>
      </div>
    </div>

    <div class="p-10">
      {{-- Info Cards --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
          <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Supplier / Vendor</p>
          <div class="flex items-center gap-3">
            <i data-lucide="truck" class="w-5 h-5 text-indigo-500"></i>
            <span class="text-sm font-bold text-slate-900">{{ $purchaseOrder->supplier->name }}</span>
          </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
          <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Gudang Penerima</p>
          <div class="flex items-center gap-3">
            <i data-lucide="warehouse" class="w-5 h-5 text-indigo-500"></i>
            <span class="text-sm font-bold text-slate-900">{{ $purchaseOrder->warehouse->name }}</span>
          </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
          <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Referensi PR</p>
          <div class="flex items-center gap-3">
            <i data-lucide="file-text" class="w-5 h-5 text-indigo-500"></i>
            <span class="text-sm font-bold text-slate-900 underline decoration-indigo-200">
              {{ $purchaseOrder->purchaseRequest->pr_number }}
            </span>
          </div>
        </div>
      </div>

      {{-- Items Table --}}
      <div class="space-y-4 mb-10">
        <div class="flex items-center gap-3">
          <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Daftar Pesanan & Status
            Kedatangan</h3>
          <div class="h-px flex-1 bg-slate-100"></div>
        </div>

        <div class="border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
          <table class="w-full text-sm text-left border-separate border-spacing-0">
            <thead class="bg-slate-50/80 text-slate-400 uppercase text-[10px] font-black tracking-widest">
              <tr>
                <th class="px-8 py-4">Item Produk</th>
                <th class="px-6 py-4 text-center">Dipesan</th>
                <th class="px-6 py-4 text-center">Diterima</th>
                <th class="px-8 py-4 text-right">Sisa (Outstanding)</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
              @foreach($purchaseOrder->items as $item)
              @php $remaining = $item->quantity - $item->received_quantity; @endphp
              <tr class="hover:bg-slate-50/30 transition-all">
                <td class="px-8 py-5">
                  <span class="font-bold text-slate-900">{{ $item->product->name }}</span>
                </td>
                <td class="px-6 py-5 text-center font-bold">
                  {{ number_format($item->quantity, 2) }}
                </td>
                <td class="px-6 py-5 text-center">
                  <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg font-bold">
                    {{ number_format($item->received_quantity, 2) }}
                  </span>
                </td>
                <td class="px-8 py-5 text-right">
                  <span class="font-black {{ $remaining > 0 ? 'text-rose-500' : 'text-slate-400' }}">
                    {{ number_format($remaining, 2) }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>



      {{-- Footer Action --}}
      <div class="pt-10 border-t border-slate-50 flex items-center justify-between">
        <div class="text-xs text-slate-400 font-medium">
          PO Terbit secara sistemik dan sah tanpa tanda tangan basah jika status <strong>APPROVED</strong>.
        </div>

        <div class="flex items-center gap-3">
          @if($purchaseOrder->status === 'DRAFT')
          <form method="POST" action="{{ route('purchase-orders.submit',$purchaseOrder) }}">
            @csrf
            <button
              class="px-8 py-4 bg-amber-500 text-white text-sm font-bold rounded-2xl hover:bg-amber-600 shadow-xl shadow-amber-100 transition-all flex items-center gap-2">
              <i data-lucide="send" class="w-4 h-4"></i> Kirim PO ke Supplier
            </button>
          </form>
          @endif

          @if($purchaseOrder->status === 'SUBMITTED')
          <form method="POST" action="{{ route('purchase-orders.approve',$purchaseOrder) }}">
            @csrf
            <button
              class="px-10 py-4 bg-emerald-600 text-white text-sm font-bold rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-100 transition-all flex items-center gap-2">
              <i data-lucide="check-circle" class="w-4 h-4"></i> Setujui PO
            </button>
          </form>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection