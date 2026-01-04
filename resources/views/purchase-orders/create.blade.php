@extends('layouts.app')

@section('title', 'Create PO from ' . $pr->pr_number)

@section('content')
<div class="max-w-6xl mx-auto p-8 pb-20">
    <div class="mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tight uppercase">Create Purchase Order</h1>
        <p class="text-slate-500 font-medium">Menerbitkan pesanan untuk {{ $pr->pr_number }}</p>
    </div>

    <form action="{{ route('purchase-orders.store') }}" method="POST" id="po-form">
        @csrf
        <input type="hidden" name="purchase_request_id" value="{{ $pr->id }}">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Sidebar Info --}}
            <div class="space-y-6">
                <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Informasi PO</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Pilih Supplier</label>
                            <select name="supplier_id" required class="w-full px-4 py-3 bg-slate-50 border-transparent rounded-xl text-sm font-bold focus:bg-white focus:ring-2 focus:ring-slate-900 transition-all">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Tanggal PO</label>
                            <input type="date" name="po_date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 bg-slate-50 border-transparent rounded-xl text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">PPN (%)</label>
                            <input type="number" name="tax_percent" id="tax_percent" value="11" min="0" class="w-full px-4 py-3 bg-slate-50 border-transparent rounded-xl text-sm font-bold calc-trigger">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-slate-50/50 text-[9px] uppercase font-black text-slate-400 tracking-widest">
                            <tr>
                                <th class="px-8 py-4">Item (Kain/Aksesoris)</th>
                                <th class="px-4 py-4 text-center">Qty</th>
                                <th class="px-8 py-4 text-right">Harga Satuan (Rp)</th>
                                <th class="px-8 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($pr->items as $index => $item)
                            <tr class="item-row">
                                <input type="hidden" name="items[{{ $index }}][product_id]" value="{{ $item->product_id }}">
                                <input type="hidden" name="items[{{ $index }}][qty]" value="{{ $item->qty }}" class="row-qty">
                                
                                <td class="px-8 py-5">
                                    <p class="text-sm font-black text-slate-900 uppercase">{{ $item->product->name }}</p>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $item->product->code }}</p>
                                </td>
                                <td class="px-4 py-5 text-center font-bold text-slate-600">
                                    {{ number_format($item->qty, 0) }} <span class="text-[9px] uppercase">{{ $item->unit_name }}</span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <input type="number" name="items[{{ $index }}][unit_price]" required step="0.01" 
                                           class="w-full px-3 py-2 bg-slate-50 border-transparent rounded-lg text-sm font-black text-right focus:bg-white focus:ring-1 focus:ring-slate-900 calc-trigger row-price" placeholder="0">
                                </td>
                                <td class="px-8 py-5 text-right font-black text-slate-900 row-total">0</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Summary --}}
                    <div class="p-8 bg-slate-900 text-white">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-[10px] font-black uppercase text-slate-400">Subtotal</span>
                            <span class="font-bold" id="subtotal-display">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-black uppercase text-slate-400">PPN Amount</span>
                            <span class="font-bold" id="tax-display">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-4 border-t border-slate-700">
                            <span class="text-xs font-black uppercase">Grand Total</span>
                            <span class="text-2xl font-black text-emerald-400" id="grand-total-display">Rp 0</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-12 py-4 bg-emerald-500 text-white rounded-2xl font-black hover:bg-emerald-600 transition-all shadow-xl shadow-emerald-100 active:scale-95">
                        DITERBITKAN PO
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('input', function (e) {
        if (e.target.classList.contains('calc-trigger')) {
            calculateTotal();
        }
    });

    function calculateTotal() {
        let subtotal = 0;
        const rows = document.querySelectorAll('.item-row');
        
        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.row-qty').value) || 0;
            const price = parseFloat(row.querySelector('.row-price').value) || 0;
            const total = qty * price;
            
            subtotal += total;
            row.querySelector('.row-total').innerText = total.toLocaleString('id-ID');
        });

        const taxPercent = parseFloat(document.getElementById('tax_percent').value) || 0;
        const taxAmount = (subtotal * taxPercent) / 100;
        const grandTotal = subtotal + taxAmount;

        document.getElementById('subtotal-display').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('tax-display').innerText = 'Rp ' + taxAmount.toLocaleString('id-ID');
        document.getElementById('grand-total-display').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
    }
</script>
@endsection