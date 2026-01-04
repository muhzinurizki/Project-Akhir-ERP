@extends('layouts.app')

@section('title', 'Detail Accounts Payable')
@section('page-title', 'Detail AP: ' . $accountsPayable->ap_number)

@section('content')
<div class="space-y-6">
  {{-- Action Header --}}
  <div class="flex items-center justify-between">
    <a href="{{ route('accounts-payables.index') }}"
      class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-900 transition-all">
      <i data-lucide="arrow-left" class="w-4 h-4"></i>
      Kembali ke Daftar
    </a>
    <div class="flex gap-2">
      <button
        class="flex items-center gap-2 px-4 py-2 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-50">
        <i data-lucide="printer" class="w-4 h-4"></i> Cetak Invoice
      </button>
      @if($accountsPayable->remaining_amount > 0)
      <a href="{{ route('accounts-payables.payment', $accountsPayable) }}"
        class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-100">
        <i data-lucide="credit-card" class="w-4 h-4"></i> Proses Pembayaran
      </a>
      @endif
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Card Utama: Ringkasan Dana --}}
    <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8">
      <div class="flex justify-between items-start mb-8">
        <div>
          <span
            class="px-3 py-1 rounded-full text-[10px] font-black border
                        {{ $accountsPayable->status === 'paid' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100' }}">
            {{ strtoupper($accountsPayable->status) }}
          </span>
          <h3 class="text-2xl font-black text-slate-900 mt-2">{{ $accountsPayable->ap_number }}</h3>
          <p class="text-slate-400 text-sm font-medium">Dibuat pada {{ $accountsPayable->created_at?->format('d M Y,
            H:i') }}</p>
        </div>
        <div class="text-right">
          <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sisa Hutang</span>
          <h2 class="text-3xl font-black text-rose-600">Rp {{ number_format($accountsPayable->remaining_amount, 0, ',',
            '.') }}</h2>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 py-6 border-y border-slate-50">
        <div>
          <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Total Tagihan</span>
          <span class="font-bold text-slate-900 text-lg">Rp {{ number_format($accountsPayable->amount, 0, ',', '.')
            }}</span>
        </div>
        <div>
          <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Sudah Dibayar</span>
          <span class="font-bold text-emerald-600 text-lg">Rp {{ number_format($accountsPayable->paid_amount, 0, ',',
            '.') }}</span>
        </div>
        <div>
          <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-1">Jatuh Tempo</span>
          <span
            class="font-bold text-slate-900 text-lg {{ $accountsPayable->due_date?->isPast() ? 'text-rose-600' : '' }}">
            {{ $accountsPayable->due_date?->format('d M Y') ?? 'N/A' }}
          </span>
        </div>
      </div>

      {{-- Riwayat Pembayaran (Log) --}}
      <div class="mt-8">
        <h4 class="text-sm font-black text-slate-900 mb-4 flex items-center gap-2">
          <i data-lucide="history" class="w-4 h-4 text-indigo-500"></i>
          Riwayat Pembayaran
        </h4>
        {{-- Di sini Anda bisa menambahkan loop riwayat jika tabel payment sudah ada --}}
        <div class="text-xs text-slate-400 italic p-4 bg-slate-50 rounded-xl border border-dashed text-center">
          Belum ada riwayat transaksi pembayaran untuk AP ini.
        </div>
      </div>
    </div>

    {{-- Sidebar: Info Supplier & Dokumen --}}
    <div class="space-y-6">
      <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm p-6">
        <h3 class="text-sm font-black text-slate-900 mb-4">Informasi Supplier</h3>
        <div class="flex items-center gap-4 mb-4">
          <div
            class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 font-black text-lg">
            {{ substr($accountsPayable->supplier?->name ?? '?', 0, 1) }}
          </div>
          <div>
            <p class="font-bold text-slate-900 leading-tight">{{ $accountsPayable->supplier?->name ?? 'Supplier N/A' }}
            </p>
            <p class="text-[10px] text-slate-400 font-medium">{{ $accountsPayable->supplier?->code ?? '-' }}</p>
          </div>
        </div>
        <div class="space-y-2 pt-4 border-t border-slate-50 text-xs">
          <div class="flex justify-between">
            <span class="text-slate-400">Kontak</span>
            <span class="font-bold text-slate-700">{{ $accountsPayable->supplier?->contact_person ?? '-' }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-slate-400">Telepon</span>
            <span class="font-bold text-slate-700">{{ $accountsPayable->supplier?->phone ?? '-' }}</span>
          </div>
        </div>
      </div>

      <div class="bg-slate-900 rounded-[2rem] shadow-sm p-6 text-white">
        <h3 class="text-sm font-black text-slate-400 mb-4 uppercase tracking-widest">Relasi Dokumen</h3>
        <ul class="space-y-4">
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <i data-lucide="file-text" class="w-4 h-4 text-indigo-400"></i>
              <span class="text-xs font-medium">Purchase Order</span>
            </div>
            <span class="text-xs font-black">{{ $accountsPayable->purchaseOrder?->po_number ?? '-' }}</span>
          </li>
          <li class="flex items-center justify-between">
            <div class="flex items-center gap-2">
              <i data-lucide="package-check" class="w-4 h-4 text-emerald-400"></i>
              <span class="text-xs font-medium">Goods Receipt</span>
            </div>
            <span class="text-xs font-black">{{ $accountsPayable->goodsReceipt?->gr_number ?? '-' }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection