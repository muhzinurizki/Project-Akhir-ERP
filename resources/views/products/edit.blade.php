@extends('layouts.app')

@section('title', 'Edit Produk | ERP Tekstil')
@section('page-title', 'Katalog Produk')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- Breadcrumb & Navigation --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('products.index') }}"
            class="group flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-widest">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </div>
            Kembali ke Katalog
        </a>

        <div class="flex items-center gap-3 self-end sm:self-auto">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Product Reference:</span>
            <span class="text-xs font-black bg-slate-900 text-white px-4 py-1.5 rounded-lg shadow-lg shadow-slate-200">#{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        {{-- Header Form --}}
        <div class="px-12 py-10 border-b border-slate-50 bg-slate-50/30 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Update Produk</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Modifikasi parameter teknis dan klasifikasi SKU.</p>
            </div>
            
            <div class="shrink-0">
                @if($product->is_active)
                    <div class="px-6 py-2 rounded-2xl bg-emerald-50 text-emerald-600 text-[10px] font-black border border-emerald-100 flex items-center gap-3 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        SISTEM AKTIF
                    </div>
                @else
                    <div class="px-6 py-2 rounded-2xl bg-slate-100 text-slate-400 text-[10px] font-black border border-slate-200 flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-slate-300"></span>
                        ARSIP / NON-AKTIF
                    </div>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('products.update', $product) }}" class="p-12 space-y-12">
            @csrf
            @method('PUT')

            {{-- Section 1: Identitas Produk --}}
            <section class="space-y-8">
                <div class="flex items-center gap-4">
                    <div class="h-px flex-1 bg-slate-100"></div>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Core Data</span>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- SKU Field --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">SKU / Kode Unik</label>
                        <div class="relative group">
                            <i data-lucide="hash" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border @error('sku') border-rose-500 @else border-slate-100 @enderror rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner uppercase tracking-tight">
                        </div>
                        @error('sku') <p class="text-[10px] text-rose-500 mt-2 font-bold ml-1 uppercase italic tracking-tighter">{{ $message }}</p> @enderror
                    </div>

                    {{-- Name Field --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Produk</label>
                        <div class="relative group">
                            <i data-lucide="package" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner">
                        </div>
                        @error('name') <p class="text-[10px] text-rose-500 mt-2 font-bold ml-1 uppercase italic tracking-tighter">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            {{-- Section 2: Klasifikasi & Stok --}}
            <section class="space-y-8">
                <div class="flex items-center gap-4">
                    <div class="h-px flex-1 bg-slate-100"></div>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Parameter Teknis</span>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    {{-- Kategori --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Kategori</label>
                        <div class="relative group">
                            <i data-lucide="layers" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 z-10"></i>
                            <select name="product_category_id"
                                class="w-full pl-14 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer shadow-inner uppercase">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('product_category_id', $product->product_category_id) == $category->id)>
                                        {{ strtoupper($category->name) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- UOM --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Satuan</label>
                        <div class="relative group">
                            <i data-lucide="scale" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 z-10"></i>
                            <select name="unit_id"
                                class="w-full pl-14 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer shadow-inner uppercase">
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" @selected(old('unit_id', $product->unit_id) == $unit->id)>
                                        {{ $unit->code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- STOCK ADJUSTMENT (NEW) --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1 italic">Manual Stock Adj.</label>
                        <div class="relative group">
                            <i data-lucide="database" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-indigo-500 z-10"></i>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" step="0.01"
                                class="w-full pl-14 pr-6 py-4 bg-indigo-50/30 border border-indigo-100 rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner text-indigo-900">
                        </div>
                    </div>
                </div>
            </section>

            {{-- Section 3: Inventory Type --}}
            <section class="space-y-5">
                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Tipe Klasifikasi Inventaris</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @php
                        $types = [
                            'raw_material' => ['label' => 'RAW MAT', 'icon' => 'box'],
                            'semi_finished' => ['label' => 'WIP', 'icon' => 'component'],
                            'finished' => ['label' => 'FINISHED', 'icon' => 'check-circle']
                        ];
                    @endphp

                    @foreach($types as $value => $data)
                        <label class="relative cursor-pointer group/type">
                            <input type="radio" name="type" value="{{ $value }}" class="sr-only peer" @checked(old('type', $product->type) == $value)>
                            
                            <div class="p-8 border-2 border-slate-50 bg-slate-50/50 rounded-[2rem] transition-all duration-300 peer-checked:border-slate-900 peer-checked:bg-white peer-checked:shadow-2xl peer-checked:shadow-slate-200/60">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center mb-4 transition-all duration-300 group-hover/type:rotate-12 shadow-sm border border-slate-50">
                                        <i data-lucide="{{ $data['icon'] }}" class="w-6 h-6 text-slate-400 group-hover/type:text-indigo-600 transition-colors"></i>
                                    </div>
                                    <p class="text-[11px] font-black text-slate-900 uppercase tracking-widest">{{ $data['label'] }}</p>
                                </div>

                                {{-- Active Indicator --}}
                                <div class="absolute top-5 right-5 w-5 h-5 rounded-full border-2 border-slate-100 peer-checked:group-[]:border-slate-900 peer-checked:group-[]:bg-slate-900 flex items-center justify-center transition-all shadow-inner">
                                    <i data-lucide="check" class="w-2.5 h-2.5 text-white opacity-0 peer-checked:group-[]:opacity-100 transition-opacity"></i>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Section 4: Status Toggle --}}
            <div class="p-10 bg-slate-900 rounded-[2.5rem] text-white flex items-center justify-between shadow-2xl shadow-slate-300 relative overflow-hidden group/toggle">
                <div class="absolute top-0 right-0 w-32 h-full bg-white/5 skew-x-[20deg] translate-x-10 group-hover/toggle:translate-x-0 transition-transform duration-700"></div>
                
                <div class="flex items-center gap-6 relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center border border-white/10 shadow-inner group-hover/toggle:scale-110 transition-transform">
                        <i data-lucide="power" class="w-7 h-7 text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="font-black text-lg tracking-tight italic uppercase">Status Produk Saat Ini</p>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.15em] mt-1">Status non-aktif akan menyembunyikan SKU dari daftar transaksi aktif.</p>
                    </div>
                </div>

                <label class="relative inline-flex items-center cursor-pointer scale-125 mr-4 z-10">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" @checked(old('is_active', $product->is_active))>
                    <div class="w-12 h-6 bg-white/10 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-lg"></div>
                </label>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-8 pt-10 border-t border-slate-50">
                <a href="{{ route('products.index') }}"
                    class="text-[11px] font-black text-slate-400 hover:text-rose-600 transition-all uppercase tracking-[0.2em]">
                    Batalkan Perubahan
                </a>
                <button type="submit"
                    class="px-14 py-5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-600 shadow-2xl shadow-indigo-200 transition-all flex items-center gap-4 active:scale-95 group">
                    <i data-lucide="refresh-cw" class="w-5 h-5 group-hover:rotate-180 transition-transform duration-500"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection