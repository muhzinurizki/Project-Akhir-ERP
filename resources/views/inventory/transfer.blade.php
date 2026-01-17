@extends('layouts.app')

@section('content')
<div class="p-6 max-w-4xl mx-auto">
    <div class="mb-8 flex items-center gap-5">
        <a href="{{ route('inventory.index') }}" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
            <i data-lucide="arrow-left" class="w-6 h-6"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Internal Transfer</h1>
            <p class="text-sm text-slate-500 font-medium">Pindahkan stok antar lokasi gudang secara aman.</p>
        </div>
    </div>

    <form action="{{ route('inventory.store-transfer') }}" method="POST" class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        @csrf
        <div class="p-10 space-y-10">
            {{-- Pilih Produk --}}
            <div class="space-y-3">
                <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Pilih Produk</label>
                <select name="product_id" required class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-bold p-4 focus:ring-2 focus:ring-indigo-500 appearance-none cursor-pointer transition-all">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->sku }} - {{ $p->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Alur Gudang --}}
            <div class="grid grid-cols-1 md:grid-cols-11 items-center gap-4 pt-8 border-t border-slate-50">
                <div class="md:col-span-5 space-y-3">
                    <label class="text-[11px] font-bold text-rose-500 uppercase tracking-widest ml-1">Gudang Asal (Keluar)</label>
                    <select name="from_warehouse_id" required class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-bold p-4 focus:ring-2 focus:ring-rose-500 appearance-none cursor-pointer transition-all">
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-1 flex justify-center pt-6">
                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <i data-lucide="arrow-right" class="w-5 h-5"></i>
                    </div>
                </div>

                <div class="md:col-span-5 space-y-3">
                    <label class="text-[11px] font-bold text-emerald-500 uppercase tracking-widest ml-1">Gudang Tujuan (Masuk)</label>
                    <select name="to_warehouse_id" required class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-bold p-4 focus:ring-2 focus:ring-emerald-500 appearance-none cursor-pointer transition-all">
                        @foreach($warehouses as $w)
                            <option value="{{ $w->id }}">{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Quantity & Note --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-50">
                <div class="space-y-4">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Jumlah Transfer</label>
                    <div class="relative group">
                        <input type="number" name="quantity" min="1" step="1" oninput="this.value = Math.abs(this.value)" required placeholder="0" 
                               class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-black text-3xl p-4 focus:ring-2 focus:ring-indigo-500 transition-all">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300 group-focus-within:text-indigo-400 tracking-widest uppercase italic">Unit</span>
                    </div>
                </div>
                <div class="space-y-4">
                    <label class="text-[11px] font-bold text-slate-400 uppercase tracking-widest ml-1">Keterangan Transfer</label>
                    <textarea name="note" rows="2" placeholder="Contoh: Kirim stok ke cabang Tangerang..." 
                              class="w-full rounded-2xl border-slate-100 bg-slate-50 text-slate-800 font-semibold p-4 focus:ring-2 focus:ring-indigo-500 transition-all"></textarea>
                </div>
            </div>
        </div>

        <div class="p-10 bg-slate-50/50 flex gap-4">
            <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest text-xs">
                Eksekusi Transfer Sekarang
            </button>
            <a href="{{ route('inventory.index') }}" class="px-10 py-4 bg-white border border-slate-200 text-slate-400 rounded-2xl font-bold hover:bg-slate-50 transition-all uppercase tracking-widest text-xs text-center">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection