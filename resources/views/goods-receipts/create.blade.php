@extends('layouts.app')

@section('title', 'Input Penerimaan Barang')
@section('page-title', 'Warehouse Operations')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
  {{-- Navigation --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('goods-receipts.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar GR
    </a>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Form --}}
    <div class="px-10 py-10 border-b border-slate-50 bg-emerald-600 text-white relative overflow-hidden">
      <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <h2 class="text-2xl font-extrabold tracking-tight">Create Goods Receipt</h2>
          <p class="text-emerald-100 text-sm mt-1 font-medium">Catat kedatangan barang secara akurat untuk memperbarui
            stok sistem.</p>
        </div>
        <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-sm border border-white/20">
          <i data-lucide="package-check" class="w-8 h-8 text-emerald-100"></i>
        </div>
      </div>
      <i data-lucide="truck" class="w-40 h-40 text-white opacity-5 absolute -right-10 -bottom-10"></i>
    </div>

    <form method="POST" action="{{ route('goods-receipts.store') }}" class="p-10">
      @csrf

      {{-- Info Utama --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
        <div class="space-y-2">
          <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Referensi Purchase Order
            (PO)</label>
          <div class="relative">
            <select name="purchase_order_id" required
              class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-emerald-50 focus:border-emerald-600 outline-none appearance-none transition-all shadow-sm">
              <option value="">Pilih PO yang sudah di-approve...</option>
              @foreach($purchaseOrders as $po)
              <option value="{{ $po->id }}">
                {{ $po->po_number }} — {{ $po->warehouse->name }}
              </option>
              @endforeach
            </select>
            <i data-lucide="file-text" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
          </div>
        </div>

        <div class="space-y-2">
          <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Tanggal Terima
            Barang</label>
          <div class="relative">
            <input type="date" name="gr_date" value="{{ date('Y-m-d') }}" required
              class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-emerald-50 focus:border-emerald-600 outline-none transition-all shadow-sm">
            <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
          </div>
        </div>
      </div>

      {{-- Table Items --}}
      <div class="space-y-4 mb-10">
        <div class="flex items-center justify-between">
          <h3 class="text-[11px] font-black text-emerald-600 uppercase tracking-[0.2em]">Daftar Item dalam PO</h3>
          <span class="text-[10px] font-bold text-slate-400 italic">* Pastikan quantity tidak melebihi sisa PO</span>
        </div>



        <div class="border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm bg-slate-50/30">
          <table class="w-full text-sm text-left border-separate border-spacing-0">
            <thead class="bg-slate-100/50 text-slate-500 uppercase text-[10px] font-black tracking-widest">
              <tr>
                <th class="px-8 py-4">Nama Produk</th>
                <th class="px-4 py-4 text-center">Qty PO</th>
                <th class="px-4 py-4 text-center">Telah Diterima</th>
                <th class="px-4 py-4 text-center">Sisa PO</th>
                <th class="px-8 py-4 text-right">Diterima Hari Ini</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
              @php $itemIndex = 0; @endphp
              @foreach($purchaseOrders as $po)
              @foreach($po->items as $item)
              @if($item->received_quantity < $item->quantity)
                <tr class="hover:bg-slate-50/50 transition-all">
                  <td class="px-8 py-5">
                    <div class="flex flex-col">
                      <span class="font-bold text-slate-900">{{ $item->product->name }}</span>
                      <span class="text-[10px] text-slate-400 font-medium">SKU: {{ $item->product->sku ?? '-' }}</span>
                    </div>
                  </td>
                  <td class="px-4 py-5 text-center font-medium text-slate-600">
                    {{ number_format($item->quantity, 2) }}
                  </td>
                  <td class="px-4 py-5 text-center font-medium text-emerald-600">
                    {{ number_format($item->received_quantity, 2) }}
                  </td>
                  <td class="px-4 py-5 text-center">
                    <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-lg font-black text-xs">
                      {{ number_format($item->quantity - $item->received_quantity, 2) }}
                    </span>
                  </td>
                  <td class="px-8 py-5 text-right">
                    <input type="hidden" name="items[{{ $itemIndex }}][purchase_order_item_id]" value="{{ $item->id }}">
                    <div
                      class="inline-flex items-center gap-2 px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus-within:border-emerald-500 focus-within:ring-4 focus-within:ring-emerald-50 transition-all">
                      <input type="number" step="0.0001" name="items[{{ $itemIndex }}][quantity]"
                        max="{{ $item->quantity - $item->received_quantity }}" placeholder="0.00"
                        class="w-24 bg-transparent border-none text-right text-sm font-black text-slate-900 focus:ring-0 p-0">
                      <span class="text-[10px] font-bold text-slate-400 uppercase">Unit</span>
                    </div>
                  </td>
                </tr>
                @php $itemIndex++; @endphp
                @endif
                @endforeach
                @endforeach
            </tbody>
          </table>
        </div>
      </div>

      {{-- Note & Submit --}}
      <div class="space-y-6 pt-6 border-t border-slate-50">
        <div class="space-y-2">
          <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Catatan Penerimaan (Kondisi
            Barang, No. Surat Jalan, dll)</label>
          <textarea name="note" rows="3"
            placeholder="Contoh: Barang diterima dalam kondisi baik, Surat Jalan No: SJ-123..."
            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-medium focus:bg-white focus:ring-4 focus:ring-emerald-50 focus:border-emerald-600 outline-none transition-all shadow-sm"></textarea>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4">
          <a href="{{ route('goods-receipts.index') }}"
            class="px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
            Batalkan
          </a>
          <button type="submit"
            class="px-12 py-4 bg-emerald-600 text-white text-sm font-bold rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-100 transition-all flex items-center gap-3 active:scale-95">
            <i data-lucide="save" class="w-5 h-5"></i>
            Simpan Penerimaan
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection