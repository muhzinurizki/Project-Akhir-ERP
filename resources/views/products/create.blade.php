@extends('layouts.app')

@section('title', 'Tambah Produk | ERP Tekstil')
@section('page-title', 'Katalog Produk')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    {{-- Back Link --}}
    <div class="mb-8">
        <a href="{{ route('products.index') }}"
            class="group flex items-center gap-3 text-[11px] font-black text-slate-400 hover:text-indigo-600 transition-all uppercase tracking-widest">
            <div class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center group-hover:border-indigo-600 group-hover:bg-indigo-50 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
            </div>
            Kembali ke Katalog
        </a>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-2xl shadow-slate-200/50 overflow-hidden">
        {{-- Header Form --}}
        <div class="px-12 py-10 border-b border-slate-50 bg-slate-50/30">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-10 h-10 rounded-2xl bg-slate-900 flex items-center justify-center text-white">
                    <i data-lucide="package-plus" class="w-5 h-5"></i>
                </div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Registrasi SKU Baru</h2>
            </div>
            <p class="text-sm text-slate-500 font-medium ml-14">Pastikan SKU unik untuk menghindari duplikasi data pada inventaris.</p>
        </div>

        <form method="POST" action="{{ route('products.store') }}" class="p-12 space-y-12">
            @csrf

            {{-- Section 1: Identitas Produk --}}
            <section class="space-y-8">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-px flex-1 bg-slate-100"></div>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Informasi Inti</span>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    {{-- SKU Field --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">SKU / Kode Produksi</label>
                        <div class="relative group">
                            <i data-lucide="fingerprint" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="sku" value="{{ old('sku') }}" placeholder="FAB-COT-30S-BLK"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border @error('sku') border-rose-500 @else border-slate-100 @enderror rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner tracking-tight uppercase">
                        </div>
                        @error('sku') <p class="text-[10px] text-rose-500 mt-2 font-bold ml-1 uppercase italic tracking-tighter">{{ $message }}</p> @enderror
                    </div>

                    {{-- Name Field --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Nama Deskriptif Produk</label>
                        <div class="relative group">
                            <i data-lucide="edit-3" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="COTTON COMBED 30S - JET BLACK"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border @error('name') border-rose-500 @else border-slate-100 @enderror rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner tracking-tight">
                        </div>
                        @error('name') <p class="text-[10px] text-rose-500 mt-2 font-bold ml-1 uppercase italic tracking-tighter">{{ $message }}</p> @enderror
                    </div>
                </div>
            </section>

            {{-- Section 2: Klasifikasi & Initial Stock --}}
            <section class="space-y-8">
                <div class="flex items-center gap-4 mb-4">
                    <div class="h-px flex-1 bg-slate-100"></div>
                    <span class="text-[10px] font-black text-slate-300 uppercase tracking-[0.3em]">Klasifikasi & Inventori</span>
                    <div class="h-px flex-1 bg-slate-100"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    {{-- Category --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Kategori</label>
                        <div class="relative group">
                            <i data-lucide="layers" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none group-focus-within:text-indigo-600 z-10"></i>
                            <select name="product_category_id"
                                class="w-full pl-14 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer shadow-inner uppercase tracking-tighter">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('product_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ strtoupper($category->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- Unit --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Satuan (UOM)</label>
                        <div class="relative group">
                            <i data-lucide="scale" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none group-focus-within:text-indigo-600 z-10"></i>
                            <select name="unit_id"
                                class="w-full pl-14 pr-10 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer shadow-inner uppercase tracking-tighter">
                                <option value="" disabled selected>Satuan</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->code }}
                                    </option>
                                @endforeach
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 pointer-events-none"></i>
                        </div>
                    </div>

                    {{-- INITIAL STOCK FIELD --}}
                    <div class="space-y-3">
                        <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Stok Awal (Saldo)</label>
                        <div class="relative group">
                            <i data-lucide="archive" class="absolute left-5 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" step="0.01"
                                class="w-full pl-14 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.5rem] text-sm font-black focus:bg-white focus:ring-8 focus:ring-indigo-600/5 focus:border-indigo-600 outline-none transition-all shadow-inner tracking-tight">
                        </div>
                        <p class="text-[9px] text-slate-400 font-bold ml-1 uppercase italic tracking-tighter">*Biarkan 0 jika belum ada stok.</p>
                    </div>
                </div>
            </section>

            {{-- Section 3: Inventory Type --}}
            <section class="space-y-4">
                <label class="text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Tipe Klasifikasi Inventaris</label>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @php
                        $types = [
                            'raw_material' => ['label' => 'RAW MAT', 'icon' => 'box', 'desc' => 'Bahan Baku'],
                            'semi_finished' => ['label' => 'WIP', 'icon' => 'component', 'desc' => 'Setengah Jadi'],
                            'finished' => ['label' => 'FINISHED', 'icon' => 'check-circle', 'desc' => 'Produk Jadi']
                        ];
                    @endphp

                    @foreach($types as $value => $data)
                        <label class="relative cursor-pointer">
                            <input type="radio" name="type" value="{{ $value }}" class="sr-only peer" {{ (old('type') ?? 'raw_material') == $value ? 'checked' : '' }}>
                            
                            <div class="p-6 border-2 border-slate-50 bg-slate-50/50 rounded-[2rem] transition-all duration-300 peer-checked:border-slate-900 peer-checked:bg-white peer-checked:shadow-xl peer-checked:shadow-slate-200/50 group">
                                <div class="flex flex-col items-center text-center">
                                    <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center mb-4 transition-all duration-300 peer-checked:group-[]:bg-slate-900 peer-checked:group-[]:text-white shadow-sm border border-slate-50">
                                        <i data-lucide="{{ $data['icon'] }}" class="w-6 h-6 text-slate-400 group-hover:text-indigo-600 transition-colors"></i>
                                    </div>
                                    <p class="text-[11px] font-black text-slate-900 uppercase tracking-widest">{{ $data['label'] }}</p>
                                    <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase tracking-tight">{{ $data['desc'] }}</p>
                                </div>

                                {{-- Active Indicator --}}
                                <div class="absolute top-4 right-4 w-4 h-4 rounded-full border-2 border-slate-200 peer-checked:group-[]:border-slate-900 peer-checked:group-[]:bg-slate-900 flex items-center justify-center transition-all">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white opacity-0 peer-checked:group-[]:opacity-100"></div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </section>

            {{-- Section 4: Status Toggle --}}
            <div class="p-8 bg-slate-50/50 rounded-[2.5rem] border border-slate-100 flex items-center justify-between group transition-all hover:bg-white hover:shadow-xl hover:shadow-slate-200/30">
                <div class="flex items-center gap-6">
                    <div class="w-14 h-14 rounded-2xl bg-white flex items-center justify-center border border-slate-100 shadow-sm group-hover:rotate-6 transition-all">
                        <i data-lucide="power" class="w-7 h-7 text-emerald-500"></i>
                    </div>
                    <div>
                        <p class="font-black text-slate-900 text-lg tracking-tight italic uppercase">Status Aktivasi</p>
                        <p class="text-[10px] text-slate-400 font-black uppercase tracking-[0.15em] mt-1">Status aktif memungkinkan item digunakan dalam modul produksi.</p>
                    </div>
                </div>

                <label class="relative inline-flex items-center cursor-pointer scale-125 mr-4">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                    <div class="w-12 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500 shadow-inner"></div>
                </label>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-6 pt-10 border-t border-slate-50">
                <a href="{{ route('products.index') }}"
                    class="text-[11px] font-black text-slate-400 hover:text-rose-600 transition-all uppercase tracking-[0.2em]">
                    Batalkan Operasi
                </a>
                <button type="submit"
                    class="px-14 py-5 bg-slate-900 text-white text-[11px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-indigo-600 shadow-2xl shadow-slate-200 transition-all flex items-center gap-4 active:scale-95 group">
                    <i data-lucide="save" class="w-5 h-5 group-hover:animate-bounce"></i>
                    Daftarkan Produk
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