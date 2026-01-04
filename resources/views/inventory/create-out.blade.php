@extends('layouts.app')

@section('content')
<div class="p-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('inventory.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center hover:bg-slate-50 transition-colors">
                <i data-lucide="arrow-left" class="w-5 h-5 text-slate-600"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 text-rose-600">Stock Out</h1>
                <p class="text-sm text-slate-500">Keluarkan barang dari gudang</p>
            </div>
        </div>

        {{-- Alert jika stok tidak cukup --}}
        @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border border-rose-100 text-rose-600 rounded-xl flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
            <form action="{{ route('inventory.store-out') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    {{-- Produk --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Produk</label>
                        <select name="product_id" class="w-full rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->code }} - {{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Gudang --}}
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Asal Gudang</label>
                        <select name="warehouse_id" class="w-full rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500" required>
                            <option value="">-- Pilih Gudang --</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Jumlah --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Keluar</label>
                            <input type="number" step="0.001" name="quantity" class="w-full rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500" placeholder="0.00" required>
                        </div>
                        {{-- Referensi --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">No. Referensi / SJ</label>
                            <input type="text" name="reference" class="w-full rounded-xl border-slate-200 focus:border-rose-500 focus:ring-rose-500" placeholder="OUT-12345" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-rose-600 text-white py-3 rounded-xl font-bold hover:bg-rose-700 transition-all shadow-lg shadow-rose-100">
                            Konfirmasi Stock Out
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection