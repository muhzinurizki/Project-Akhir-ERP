@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-8">
    {{-- Header & Back Button --}}
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('inventory.stocks.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 flex items-center justify-center text-slate-400 hover:text-slate-900 transition-colors shadow-sm">
                <i data-lucide="chevron-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Manual Stock Out</h1>
                <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Pengurangan Stok Barang</p>
            </div>
        </div>
    </div>

    {{-- Error Alert --}}
    @if($errors->any())
    <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-[2rem] flex items-start gap-3">
        <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500 shrink-0 mt-0.5"></i>
        <div class="text-sm text-rose-600 font-bold">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <form id="stockout_form" action="{{ route('inventory.stock-out.store') }}" method="POST" novalidate>
        @csrf
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl overflow-hidden">
            <div class="p-8 space-y-6">

                {{-- Product Selection --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="product_id" class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Select Product</label>
                        <select id="product_id" name="product_id" autofocus aria-required="true" class="w-full p-4 {{ $errors->has('product_id') ? 'border-rose-500 bg-white' : 'border-2 border-transparent' }} focus:border-rose-500 focus:bg-white rounded-2xl font-bold transition-all outline-none" required aria-describedby="product_id_error">
                            <option value="">-- Choose Product --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-unit="{{ $product->unit }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->unit }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p id="product_id_error" class="mt-2 text-xs text-rose-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Warehouse Selection --}}
                    <div>
                        <label for="warehouse_id" class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">From Warehouse</label>
                        <select id="warehouse_id" name="warehouse_id" aria-required="true" class="w-full p-4 {{ $errors->has('warehouse_id') ? 'border-rose-500 bg-white' : 'border-2 border-transparent' }} focus:border-rose-500 focus:bg-white rounded-2xl font-bold transition-all outline-none" required aria-describedby="warehouse_id_error">
                            <option value="">-- Choose Warehouse --</option>
                            @foreach($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('warehouse_id')
                            <p id="warehouse_id_error" class="mt-2 text-xs text-rose-600 font-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Quantity & Reference --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                           <label for="quantity" class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Quantity to Issue</label>
                        <div class="relative">
                            <input id="quantity" type="number" step="0.0001" min="0" inputmode="decimal" name="quantity" value="{{ old('quantity') }}"
                                class="w-full p-4 {{ $errors->has('quantity') ? 'border-rose-500 bg-white' : 'border-2 border-transparent' }} bg-slate-50 focus:border-rose-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                                   placeholder="0.00" required aria-describedby="quantity_error">
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase"><span id="unit_display">QTY</span></div>
                        @error('quantity')
                            <p id="quantity_error" class="mt-2 text-xs text-rose-600 font-bold">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                    <div>
                           <label for="reference" class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Reference Number</label>
                           <input id="reference" type="text" name="reference" value="{{ old('reference') }}"
                               class="w-full p-4 {{ $errors->has('reference') ? 'border-rose-500 bg-white' : 'border-2 border-transparent' }} bg-slate-50 focus:border-rose-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                               placeholder="e.g. PROD-OUT-202401" required aria-describedby="reference_error">
                           @error('reference')
                            <p id="reference_error" class="mt-2 text-xs text-rose-600 font-bold">{{ $message }}</p>
                           @enderror
                    </div>
                </div>

                {{-- Internal Note --}}
                <div>
                    <label for="note" class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-1 tracking-widest">Internal Note / Reason</label>
                    <textarea id="note" name="note" rows="3"
                              class="w-full p-4 {{ $errors->has('note') ? 'border-rose-500 bg-white' : 'border-2 border-transparent' }} bg-slate-50 focus:border-rose-500 focus:bg-white rounded-2xl font-bold transition-all outline-none"
                              placeholder="Describe why the stock is being removed..." aria-describedby="note_error">{{ old('note') }}</textarea>
                    @error('note')
                        <p id="note_error" class="mt-2 text-xs text-rose-600 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Footer Action --}}
            <div class="p-8 bg-slate-50 border-t border-slate-100 flex items-center justify-between gap-4">
                <div class="hidden md:block">
                    <p class="text-[10px] font-bold text-slate-400 uppercase leading-tight italic">
                        *Sistem akan memvalidasi sisa stok secara otomatis sebelum memproses transaksi ini.
                    </p>
                </div>
                <button type="submit" class="w-full md:w-auto px-12 py-5 bg-rose-600 text-white font-black rounded-2xl shadow-xl shadow-rose-200 hover:bg-rose-700 transition-all uppercase tracking-widest text-xs">
                    Execute Stock Out
                </button>
            </div>
        </div>
    </form>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSelect = document.getElementById('product_id');
            const unitDisplay = document.getElementById('unit_display');
            const warehouseSelect = document.getElementById('warehouse_id');
            const qtyInput = document.getElementById('quantity');
            const form = document.getElementById('stockout_form');
            const submitBtn = form.querySelector('button[type="submit"]');

            function updateUnit() {
                const opt = productSelect.options[productSelect.selectedIndex];
                const unit = (opt && opt.dataset && opt.dataset.unit) ? opt.dataset.unit : 'QTY';
                unitDisplay.textContent = unit;
            }

            function showClientError(fieldId, message) {
                const field = document.getElementById(fieldId);
                if (!field) return;
                const wrapper = field.closest('div') || field.parentNode;
                const id = fieldId + '_client_error';
                let el = document.getElementById(id);
                if (!el) {
                    el = document.createElement('p');
                    el.id = id;
                    el.className = 'mt-2 text-xs text-rose-600 font-bold';
                    wrapper.appendChild(el);
                }
                el.textContent = message;
                field.classList.add('border-rose-500', 'bg-white');
            }

            function clearClientErrors() {
                ['product_id','warehouse_id','quantity','reference','note'].forEach(function(f){
                    const el = document.getElementById(f + '_client_error');
                    if (el) el.remove();
                    const field = document.getElementById(f);
                    if (field) field.classList.remove('border-rose-500');
                });
            }

            productSelect.addEventListener('change', updateUnit);
            updateUnit();

            form.addEventListener('submit', function (e) {
                clearClientErrors();
                let firstInvalid = null;
                const productVal = productSelect.value && productSelect.value.trim();
                const warehouseVal = warehouseSelect.value && warehouseSelect.value.trim();
                const qtyVal = parseFloat(qtyInput.value);
                const ref = (document.getElementById('reference') || {}).value || '';

                if (!productVal) { showClientError('product_id', 'Product is required'); firstInvalid = firstInvalid || productSelect; }
                if (!warehouseVal) { showClientError('warehouse_id', 'Warehouse is required'); firstInvalid = firstInvalid || warehouseSelect; }
                if (!ref.trim()) { showClientError('reference', 'Reference is required'); firstInvalid = firstInvalid || document.getElementById('reference'); }
                if (!(qtyVal > 0)) { showClientError('quantity', 'Quantity must be greater than 0'); firstInvalid = firstInvalid || qtyInput; }

                if (firstInvalid) {
                    e.preventDefault();
                    firstInvalid.focus();
                    return false;
                }

                // Prevent double submit
                submitBtn.disabled = true;
                submitBtn.setAttribute('aria-busy', 'true');
            });
        });
    </script>

@endsection