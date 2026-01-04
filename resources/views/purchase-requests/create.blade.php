@extends('layouts.app')

@section('title', 'Buat Purchase Request | ERP Tekstil')

@section('content')
<div class="max-w-6xl mx-auto p-8 pb-32">
    {{-- Breadcrumb & Navigation --}}
    <div class="mb-10 flex items-center justify-between">
        <div>
            <a href="{{ route('purchase-requests.index') }}" class="group inline-flex items-center gap-2 text-slate-400 hover:text-slate-900 font-black text-[10px] uppercase tracking-[0.2em] mb-4 transition-all">
                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                Back to Inventory
            </a>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none">New Request</h1>
            <p class="text-slate-500 font-medium mt-2">Formulir pengadaan barang departemen.</p>
        </div>
        <div class="hidden md:block">
            <div class="p-4 bg-slate-50 rounded-3xl border border-slate-100">
                <i data-lucide="clipboard-list" class="w-8 h-8 text-slate-300"></i>
            </div>
        </div>
    </div>

    <form action="{{ route('purchase-requests.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            {{-- Form Kiri: Metadata (Col 4) --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm sticky top-8">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">General Info</h3>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3">Request Date</label>
                            <div class="relative">
                                <i data-lucide="calendar" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                <input type="date" name="request_date" value="{{ date('Y-m-d') }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold focus:ring-2 focus:ring-slate-900 transition-all shadow-inner">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] mb-3">Purpose / Note</label>
                            <textarea name="note" rows="5" placeholder="Tuliskan alasan pengadaan atau instruksi tambahan..."
                                class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-medium focus:ring-2 focus:ring-slate-900 transition-all shadow-inner resize-none"></textarea>
                        </div>

                        <div class="pt-4 border-t border-slate-50">
                            <div class="flex items-center gap-3 text-slate-400">
                                <i data-lucide="info" class="w-4 h-4 text-amber-500"></i>
                                <p class="text-[10px] font-bold leading-relaxed uppercase tracking-tight">Status awal akan disetel ke <span class="text-slate-900 font-black">PENDING APPROVAL</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Kanan: Item List (Col 8) --}}
            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-500 rounded-lg shadow-lg shadow-indigo-100">
                                <i data-lucide="layers" class="w-4 h-4 text-white"></i>
                            </div>
                            <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Requested Items</h3>
                        </div>

                        <button type="button" id="add-item" class="group flex items-center gap-2 px-5 py-2.5 bg-slate-900 text-white rounded-xl text-[10px] font-black hover:bg-slate-800 transition-all active:scale-95 uppercase tracking-widest shadow-xl shadow-slate-200">
                            <i data-lucide="plus-circle" class="w-4 h-4 group-hover:rotate-90 transition-transform"></i>
                            Add Row
                        </button>
                    </div>

                    <div class="p-8">
                        <div id="item-container" class="space-y-4">
                            {{-- Baris Pertama Default --}}
                            <div class="item-row group/row relative p-6 bg-slate-50/50 rounded-3xl border border-transparent hover:border-slate-100 hover:bg-white transition-all duration-300">
                                <div class="grid grid-cols-12 gap-6 items-end">
                                    <div class="col-span-12 md:col-span-8">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Select Product</label>
                                        <div class="relative">
                                            <i data-lucide="box" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                                            <select name="items[0][product_id]" required class="w-full pl-12 pr-10 py-4 bg-white border-none rounded-2xl text-sm font-black focus:ring-2 focus:ring-slate-900 appearance-none shadow-sm ring-1 ring-slate-100 uppercase tracking-tight">
                                                <option value="">-- Choose Item --</option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-span-10 md:col-span-3">
                                        <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 text-right">Quantity</label>
                                        <input type="number" name="items[0][quantity]" step="0.01" placeholder="0.00" required
                                               class="w-full px-5 py-4 bg-white border-none rounded-2xl text-sm font-black focus:ring-2 focus:ring-slate-900 text-right shadow-sm ring-1 ring-slate-100">
                                    </div>
                                    <div class="col-span-2 md:col-span-1 flex justify-center pb-3">
                                        {{-- Spacer for first row alignment --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center md:text-left leading-relaxed">
                                Pastikan barang yang diminta sudah sesuai dengan <br><span class="text-slate-900">kebutuhan stok produksi</span> saat ini.
                            </p>
                            <button type="submit" class="w-full md:w-auto px-12 py-5 bg-emerald-500 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-emerald-600 transition-all shadow-2xl shadow-emerald-100 active:scale-95 flex items-center justify-center gap-3">
                                <i data-lucide="send" class="w-4 h-4"></i>
                                Submit Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>



<script>
    let rowIndex = 1;
    const container = document.getElementById('item-container');
    const addButton = document.getElementById('add-item');

    addButton.addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'item-row group/row relative p-6 bg-slate-50/50 rounded-3xl border border-transparent hover:border-slate-100 hover:bg-white transition-all duration-300 animate-in fade-in slide-in-from-top-4';
        row.innerHTML = `
            <div class="grid grid-cols-12 gap-6 items-end">
                <div class="col-span-12 md:col-span-8">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2">Select Product</label>
                    <div class="relative">
                        <i data-lucide="box" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300"></i>
                        <select name="items[${rowIndex}][product_id]" required class="w-full pl-12 pr-10 py-4 bg-white border-none rounded-2xl text-sm font-black focus:ring-2 focus:ring-slate-900 appearance-none shadow-sm ring-1 ring-slate-100 uppercase tracking-tight">
                            <option value="">-- Choose Item --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->code }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-span-10 md:col-span-3">
                    <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 text-right">Quantity</label>
                    <input type="number" name="items[${rowIndex}][quantity]" step="0.01" placeholder="0.00" required
                           class="w-full px-5 py-4 bg-white border-none rounded-2xl text-sm font-black focus:ring-2 focus:ring-slate-900 text-right shadow-sm ring-1 ring-slate-100">
                </div>
                <div class="col-span-2 md:col-span-1 flex justify-center pb-3">
                    <button type="button" class="remove-row p-2 text-slate-300 hover:text-rose-500 transition-all hover:bg-rose-50 rounded-lg">
                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(row);
        lucide.createIcons();
        rowIndex++;
    });

    container.addEventListener('click', (e) => {
        if (e.target.closest('.remove-row')) {
            const row = e.target.closest('.item-row');
            row.classList.add('animate-out', 'fade-out', 'slide-out-to-top-4');
            setTimeout(() => row.remove(), 200);
        }
    });

    lucide.createIcons();
</script>
@endsection