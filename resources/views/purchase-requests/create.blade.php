@extends('layouts.app')

@section('title', 'Buat Purchase Request')
@section('page-title', 'Procurement')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
  {{-- Navigation --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('purchase-requests.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar PR
    </a>
  </div>

  <form method="POST" action="{{ route('purchase-requests.store') }}" class="space-y-6">
    @csrf

    {{-- Header Card --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
      <div class="px-10 py-10 border-b border-slate-50 bg-slate-900 text-white relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <h2 class="text-2xl font-extrabold tracking-tight">Formulir Pengajuan Pembelian</h2>
            <p class="text-slate-400 text-sm mt-1 font-medium">Lengkapi detail permintaan barang untuk diproses oleh
              departemen Purchasing.</p>
          </div>
          <div
            class="flex items-center gap-3 bg-white/10 px-6 py-4 rounded-2xl backdrop-blur-md border border-white/10">
            <i data-lucide="calendar" class="w-5 h-5 text-indigo-400"></i>
            <div class="flex flex-col">
              <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Tanggal Pengajuan</span>
              <input type="date" name="request_date" value="{{ date('Y-m-d') }}"
                class="bg-transparent text-sm font-bold outline-none border-none p-0 focus:ring-0">
            </div>
          </div>
        </div>
      </div>

      <div class="p-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Gudang Tujuan /
              Penerima</label>
            <div class="relative">
              <select name="warehouse_id" required
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none appearance-none transition-all shadow-sm">
                <option value="">Pilih Gudang</option>
                @foreach($warehouses as $w)
                <option value="{{ $w->id }}">{{ $w->name }}</option>
                @endforeach
              </select>
              <i data-lucide="warehouse" class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>

          <div class="space-y-2">
            <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Keterangan /
              Urgency</label>
            <div class="relative">
              <input type="text" name="note" placeholder="Contoh: Stok kritis untuk produksi minggu depan"
                class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              <i data-lucide="message-square"
                class="w-4 h-4 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2"></i>
            </div>
          </div>
        </div>

        {{-- Item Table Area --}}
        <div class="space-y-4">
          <div class="flex items-center gap-3">
            <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">Daftar Item Barang</h3>
            <div class="h-px flex-1 bg-slate-100"></div>
          </div>

          <div class="border border-slate-100 rounded-3xl overflow-hidden shadow-sm">
            <table class="w-full text-sm text-left">
              <thead class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-bold tracking-[0.15em]">
                <tr>
                  <th class="px-6 py-4 w-1/2">Produk</th>
                  <th class="px-6 py-4 w-1/4">Kuantitas</th>
                  <th class="px-6 py-4 w-1/4">Catatan Per Item</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50">
                @for($i = 0; $i < 5; $i++) <tr class="hover:bg-slate-50/30 transition-all group">
                  <td class="px-6 py-4">
                    <select name="items[{{ $i }}][product_id]"
                      class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none">
                      <option value="">Cari Produk...</option>
                      @foreach($products as $p)
                      <option value="{{ $p->id }}">{{ $p->name }}</option>
                      @endforeach
                    </select>
                  </td>
                  <td class="px-6 py-4">
                    <div class="relative">
                      <input type="number" step="0.0001" name="items[{{ $i }}][quantity]" placeholder="0.0000"
                        class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm font-black focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none">
                    </div>
                  </td>
                  <td class="px-6 py-4">
                    <input type="text" name="items[{{ $i }}][note]" placeholder="..."
                      class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2 text-sm font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 outline-none">
                  </td>
                  </tr>
                  @endfor
              </tbody>
            </table>
          </div>
          <p class="text-[10px] text-slate-400 italic ml-2">* Kosongkan baris jika tidak diperlukan. Pastikan satuan
            produk sesuai dengan standar gudang.</p>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pt-10 mt-10 border-t border-slate-50">
          <a href="{{ route('purchase-requests.index') }}"
            class="px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
            Batalkan
          </a>
          <button type="submit"
            class="px-12 py-4 bg-indigo-600 text-white text-sm font-bold rounded-2xl hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center gap-3 active:scale-95">
            <i data-lucide="send" class="w-5 h-5"></i>
            Kirim Pengajuan (PR)
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection