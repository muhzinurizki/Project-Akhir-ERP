@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('purchase-requests.index') }}" class="p-3 bg-white border border-slate-200 rounded-xl hover:bg-slate-50">
             <i data-lucide="arrow-left" class="w-4 h-4 text-slate-600"></i>
        </a>
        <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Buat Request Baru</h1>
    </div>

    <form action="{{ route('purchase-requests.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="bg-white rounded-[2.5rem] border border-slate-200 p-8 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal</label>
                    <input type="date" name="request_date" required value="{{ date('Y-m-d') }}" class="w-full rounded-2xl border-slate-200 focus:ring-slate-900">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan</label>
                    <input type="text" name="note" class="w-full rounded-2xl border-slate-200 focus:ring-slate-900" placeholder="Keterangan PR...">
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Daftar Barang</h3>
                    <button type="button" onclick="addItem()" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest flex items-center gap-1">
                        + Tambah Baris
                    </button>
                </div>

                <div id="item-list" class="space-y-3">
                    <div class="grid grid-cols-12 gap-3 item-row">
                        <div class="col-span-8">
                            <select name="items[0][product_id]" required class="w-full rounded-xl border-slate-200 text-sm">
                                <option value="">Pilih Produk...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit_name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-3">
                            <input type="number" name="items[0][qty]" required min="1" placeholder="Qty" class="w-full rounded-xl border-slate-200 text-sm">
                        </div>
                        <div class="col-span-1"></div>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full mt-10 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 shadow-xl shadow-slate-200">
                Simpan Purchase Request
            </button>
        </div>
    </form>
</div>

<script>
    let rowIdx = 1;
    function addItem() {
        const list = document.getElementById('item-list');
        const row = document.createElement('div');
        row.className = 'grid grid-cols-12 gap-3 item-row';
        row.innerHTML = `
            <div class="col-span-8">
                <select name="items[${rowIdx}][product_id]" required class="w-full rounded-xl border-slate-200 text-sm">
                    <option value="">Pilih Produk...</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->unit_name }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-span-3">
                <input type="number" name="items[${rowIdx}][qty]" required min="1" placeholder="Qty" class="w-full rounded-xl border-slate-200 text-sm">
            </div>
            <div class="col-span-1 flex items-center">
                <button type="button" onclick="this.closest('.item-row').remove()" class="text-rose-500 font-bold text-xs uppercase">X</button>
            </div>
        `;
        list.appendChild(row);
        rowIdx++;
    }
</script>
@endsection