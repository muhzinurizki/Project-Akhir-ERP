@extends('layouts.app')

@section('title', 'Buat Pesanan Pembelian')
@section('page-title', 'Procurement')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
  {{-- Navigation --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('purchase-orders.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar PO
    </a>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Form --}}
    <div class="px-10 py-10 border-b border-slate-50 bg-indigo-600 text-white relative overflow-hidden">
      <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
          <h2 class="text-2xl font-extrabold tracking-tight">Create Purchase Order</h2>
          <p class="text-indigo-100 text-sm mt-1 font-medium">Terbitkan dokumen pesanan resmi kepada supplier
            berdasarkan PR yang disetujui.</p>
        </div>
        <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-sm border border-white/20">
          <i data-lucide="shopping-bag" class="w-8 h-8 text-indigo-200"></i>
        </div>
      </div>
      <i data-lucide="file-signature" class="w-40 h-40 text-white opacity-5 absolute -right-10 -bottom-10"></i>
    </div>

    <form method="POST" action="{{ route('purchase-orders.store') }}" class="p-10 space-y-8">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Kiri: Referensi PR & Supplier --}}
        <div class="space-y-6">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">01. Referensi Sumber</h3>
            <div class="h-px flex-1 bg-slate-100"></div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Purchase Request
              (Approved)</label>
            <div class="relative">
              <select name="purchase_request_id" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none appearance-none transition-all shadow-sm">
                <option value="">Pilih Nomor PR...</option>
                @foreach($purchaseRequests as $pr)
                <option value="{{ $pr->id }}">
                  {{ $pr->pr_number }} — {{ $pr->warehouse->name }}
                </option>
                @endforeach
              </select>
              <i data-lucide="file-check" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Pilih Supplier /
              Vendor</label>
            <div class="relative">
              <select name="supplier_id" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none appearance-none transition-all shadow-sm">
                <option value="">Pilih Supplier...</option>
                @foreach($suppliers as $supplier)
                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
              </select>
              <i data-lucide="truck" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>
        </div>

        {{-- Kanan: Tanggal & Keterangan --}}
        <div class="space-y-6">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">02. Detail Transaksi</h3>
            <div class="h-px flex-1 bg-slate-100"></div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Tanggal Terbit PO</label>
            <div class="relative">
              <input type="date" name="po_date" value="{{ date('Y-m-d') }}" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              <i data-lucide="calendar" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Catatan Tambahan
              (Opsional)</label>
            <div class="relative">
              <textarea name="note" rows="3" placeholder="Tambahkan instruksi pengiriman atau termin pembayaran..."
                class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm"></textarea>
              <i data-lucide="message-circle" class="w-4 h-4 text-slate-400 absolute left-4 top-4"></i>
            </div>
          </div>
        </div>
      </div>

      {{-- Footer Actions --}}
      <div class="flex items-center justify-end gap-4 pt-10 mt-6 border-t border-slate-50">
        <a href="{{ route('purchase-orders.index') }}"
          class="px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
          Batalkan
        </a>
        <button type="submit"
          class="px-12 py-4 bg-indigo-600 text-white text-sm font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center gap-3 active:scale-95">
          <i data-lucide="check-circle" class="w-5 h-5"></i>
          Simpan & Terbitkan PO
        </button>
      </div>
    </form>
  </div>
</div>
@endsection