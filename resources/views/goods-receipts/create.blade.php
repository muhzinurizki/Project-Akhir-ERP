@extends('layouts.app')

@section('title', 'Penerimaan Barang | ERP Tekstil')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Notifikasi Error Validasi Form --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-xl shadow-sm">
        <div class="flex items-center gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
            <p class="text-sm text-rose-700 font-bold uppercase tracking-tight">Periksa Inputan Anda:</p>
        </div>
        <ul class="mt-2 ml-8 list-disc text-xs text-rose-600 font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Notifikasi Error Database/Sistem --}}
    @if(session('error'))
    <div class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-500 rounded-xl shadow-sm">
        <div class="flex items-center gap-3">
            <i data-lucide="shield-alert" class="w-5 h-5 text-amber-600"></i>
            <p class="text-sm text-amber-800 font-bold uppercase tracking-tight">Gagal Menyimpan ke Database:</p>
        </div>
        <p class="mt-1 ml-8 text-xs text-amber-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <form action="{{ route('goods-receipts.store') }}" method="POST" id="gr-form">
        @csrf
        <input type="hidden" name="purchase_order_id" value="{{ $po->id }}">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-blue-600 rounded-[1.5rem] shadow-2xl shadow-blue-200 flex items-center justify-center">
                    <i data-lucide="package-check" class="w-8 h-8 text-white"></i>
                </div>
                <div>
                    <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Goods Receipt</h1>
                    <p class="text-slate-500 font-medium flex items-center gap-2">
                        <span class="px-2 py-0.5 bg-slate-100 rounded text-[10px] font-black text-slate-500 uppercase tracking-widest">PO Ref</span>
                        <span class="text-slate-900 font-bold uppercase tracking-tight">{{ $po->po_number }}</span>
                    </p>
                </div>
            </div>
            <button type="submit" 
                    onclick="this.disabled=true; this.innerHTML='Memproses...'; this.form.submit();"
                    class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-black hover:bg-blue-700 transition-all shadow-xl active:scale-95 text-xs uppercase tracking-widest flex items-center gap-3">
                <i data-lucide="database" class="w-5 h-5"></i>
                Update Stok & Simpan
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Column: Detail Penerimaan --}}
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-8 flex items-center gap-2">
                        <i data-lucide="clipboard-list" class="w-4 h-4"></i> Informasi Logistik
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1 tracking-widest">Nomor GR (Auto)</label>
                            <input type="text" value="{{ $gr_number }}" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-slate-500 font-black italic cursor-not-allowed" readonly>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-blue-600 uppercase mb-2 ml-1 tracking-widest">No. Surat Jalan / Invoice *</label>
                            <input type="text" name="surat_jalan_number" value="{{ old('surat_jalan_number') }}" required placeholder="SJ-12345..." class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl text-slate-900 font-black focus:border-blue-500 focus:ring-0 transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-blue-600 uppercase mb-2 ml-1 tracking-widest">Tanggal Terima *</label>
                            <input type="date" name="received_date" value="{{ old('received_date', date('Y-m-d')) }}" required class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl text-slate-900 font-black focus:border-blue-500 focus:ring-0 transition-all">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 ml-1 tracking-widest">Catatan Kondisi Barang</label>
                            <textarea name="note" rows="4" class="w-full px-5 py-4 bg-white border-2 border-slate-100 rounded-2xl text-slate-900 font-bold focus:border-blue-500 focus:ring-0 transition-all" placeholder="Misal: Barang diterima dalam kondisi baik...">{{ old('note') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Item Verification --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50/50 border-b border-slate-100">
                            <tr class="text-slate-400 text-[9px] uppercase font-black tracking-[0.2em]">
                                <th class="px-8 py-6">Material / Barang</th>
                                <th class="px-6 py-6 text-center">Dipesan (PO)</th>
                                <th class="px-8 py-6 text-right text-blue-600">Diterima Nyata</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($po->items as $index => $item)
                            <tr>
                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                <input type="hidden" name="items[{{ $index }}][qty_ordered]" value="{{ $item->qty }}">
                                
                                <td class="px-8 py-6">
                                    <div class="font-black text-slate-900 uppercase italic tracking-tighter">{{ $item->product->name }}</div>
                                    <div class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">SKU: {{ $item->product->sku ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-6 text-center">
                                    <span class="px-3 py-1 bg-slate-100 rounded-full font-black text-slate-600 text-sm italic">
                                        {{ number_format($item->qty, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-end">
                                        <div class="relative w-32">
                                            <input type="number" name="items[{{ $index }}][qty_received]" 
                                                value="{{ old('items.'.$index.'.qty_received', $item->qty) }}" 
                                                step="0.01" min="0" required
                                                class="w-full px-4 py-3 bg-blue-50 border-none rounded-xl text-blue-900 font-black text-right focus:ring-2 focus:ring-blue-500 transition-all">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection