@extends('layouts.app')

@section('title', 'Detail Penerimaan Barang')
@section('page-title', 'Warehouse Audit')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
  {{-- Action Bar --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('goods-receipts.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar GR
    </a>

    <button onclick="window.print()"
      class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all shadow-sm">
      <i data-lucide="printer" class="w-4 h-4"></i>
      Cetak Bukti Penerimaan
    </button>
  </div>

  <div
    class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden print:border-none print:shadow-none">
    {{-- Header: Info Utama --}}
    <div
      class="px-10 py-10 border-b border-slate-50 bg-slate-50/50 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
      <div class="relative z-10">
        <div class="flex items-center gap-3 mb-2">
          <span
            class="text-[10px] font-black bg-emerald-600 text-white px-3 py-1 rounded-full tracking-widest uppercase shadow-lg shadow-emerald-100">Verified
            Receipt</span>
          <span class="text-slate-400 text-xs font-bold">{{ $goodsReceipt->gr_date->format('d F Y') }}</span>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight uppercase">{{ $goodsReceipt->gr_number }}</h2>
      </div>

      <div
        class="flex items-center gap-4 px-6 py-4 rounded-[2rem] bg-white border border-slate-100 shadow-sm relative z-10">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
          <i data-lucide="check-circle-2" class="w-6 h-6"></i>
        </div>
        <div class="flex flex-col">
          <span class="text-[10px] font-black uppercase tracking-widest text-slate-400 opacity-60">Status Stok</span>
          <span class="text-sm font-black text-emerald-600 tracking-tight">Sudah Masuk (In-Stock)</span>
        </div>
      </div>
    </div>

    <div class="p-10">
      {{-- Info Cards --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
          <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Referensi Dokumen</p>
          <div class="flex items-center gap-3">
            <i data-lucide="file-text" class="w-5 h-5 text-indigo-500"></i>
            <span class="text-sm font-bold text-slate-900">{{ $goodsReceipt->purchaseOrder->po_number }}</span>
          </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
          <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Lokasi Gudang</p>
          <div class="flex items-center gap-3">
            <i data-lucide="warehouse" class="w-5 h-5 text-indigo-500"></i>
            <span class="text-sm font-bold text-slate-900">{{ $goodsReceipt->warehouse->name }}</span>
          </div>
        </div>

        <div class="p-6 rounded-3xl bg-slate-50/50 border border-slate-100">
          <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Petugas Penerima</p>
          <div class="flex items-center gap-3">
            <i data-lucide="user-check" class="w-5 h-5 text-indigo-500"></i>
            <span class="text-sm font-bold text-slate-900">{{ $goodsReceipt->receiver->name }}</span>
          </div>
        </div>
      </div>

      {{-- Items Table --}}
      <div class="space-y-4 mb-10">
        <div class="flex items-center gap-3">
          <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Item Yang Diterima</h3>
          <div class="h-px flex-1 bg-slate-100"></div>
        </div>

        <div class="border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm">
          <table class="w-full text-sm text-left border-separate border-spacing-0">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
              <tr>
                <th class="px-8 py-4">Produk</th>
                <th class="px-8 py-4 text-right">Kuantitas Masuk</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
              @foreach($goodsReceipt->items as $item)
              <tr class="hover:bg-slate-50/30 transition-all">
                <td class="px-8 py-5">
                  <div class="flex flex-col">
                    <span class="font-bold text-slate-900">{{ $item->product->name }}</span>
                    <span class="text-[10px] text-slate-400 font-medium">SKU: {{ $item->product->sku ?? '-' }}</span>
                  </div>
                </td>
                <td class="px-8 py-5 text-right font-black text-emerald-600 text-lg tracking-tight">
                  {{ number_format($item->quantity, 2) }} <span
                    class="text-[10px] text-slate-400 font-bold uppercase ml-1">Unit</span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- Note Section --}}
      @if($goodsReceipt->note)
      <div class="p-6 rounded-3xl bg-amber-50/50 border border-amber-100">
        <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-2">Catatan Penerimaan</p>
        <p class="text-sm text-slate-600 italic font-medium">"{{ $goodsReceipt->note }}"</p>
      </div>
      @endif

      {{-- Signature Placeholder (Visible only on print) --}}
      <div class="hidden print:grid grid-cols-2 gap-10 mt-20 text-center">
        <div>
          <p class="text-xs font-bold text-slate-400 uppercase mb-20 tracking-widest">Diserahkan Oleh (Supplier)</p>
          <div class="w-48 h-px bg-slate-300 mx-auto"></div>
        </div>
        <div>
          <p class="text-xs font-bold text-slate-400 uppercase mb-20 tracking-widest">Diterima Oleh (Gudang)</p>
          <p class="font-bold text-slate-900">{{ $goodsReceipt->receiver->name }}</p>
          <div class="w-48 h-px bg-slate-300 mx-auto mt-2"></div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection