@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-8">
    <form action="{{ route('purchase-orders.store') }}" method="POST">
        @csrf
        <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tighter mb-8">Create Purchase Order</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Left Side: Info --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Supplier</label>
                            <select name="supplier_id" required class="w-full rounded-2xl border-slate-200">
                                <option value="">Pilih Supplier...</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block">Ref. PR (Opsional)</label>
                            <select name="purchase_request_id" class="w-full rounded-2xl border-slate-200">
                                <option value="">Tanpa Referensi PR</option>
                                @foreach($approvedPRs as $pr)
                                    <option value="{{ $pr->id }}">{{ $pr->pr_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="item-list" class="space-y-4">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest border-b pb-2">Order Items</h3>
                        <div class="grid grid-cols-12 gap-3 item-row">
                            <div class="col-span-5">
                                <select name="items[0][product_id]" required class="w-full rounded-xl border-slate-200 text-sm">
                                    @foreach($products as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <input type="number" name="items[0][qty]" placeholder="Qty" oninput="calculate()" class="qty w-full rounded-xl border-slate-200 text-sm">
                            </div>
                            <div class="col-span-4">
                                <input type="number" name="items[0][price]" placeholder="Price" oninput="calculate()" class="price w-full rounded-xl border-slate-200 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Summary --}}
            <div class="lg:col-span-1">
                <div class="bg-slate-900 text-white p-8 rounded-[2.5rem] sticky top-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Order Summary</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-400">Subtotal</span>
                            <span id="label-subtotal" class="font-bold">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-slate-400">Tax (11%)</span>
                            <span id="label-tax" class="font-bold">0</span>
                        </div>
                        <div class="border-t border-slate-700 pt-4 flex justify-between">
                            <span class="text-sm font-black uppercase">Grand Total</span>
                            <span id="label-total" class="text-xl font-black text-indigo-400">0</span>
                        </div>
                    </div>
                    <button type="submit" class="w-full mt-8 py-4 bg-indigo-500 rounded-2xl font-black text-xs uppercase tracking-widest">Publish PO</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function calculate() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = row.querySelector('.qty').value || 0;
            const price = row.querySelector('.price').value || 0;
            subtotal += (qty * price);
        });
        
        const tax = subtotal * 0.11;
        const total = subtotal + tax;

        document.getElementById('label-subtotal').innerText = subtotal.toLocaleString('id-ID');
        document.getElementById('label-tax').innerText = tax.toLocaleString('id-ID');
        document.getElementById('label-total').innerText = total.toLocaleString('id-ID');
    }
</script>
@endsection