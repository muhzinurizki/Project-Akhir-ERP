@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto p-8">
    <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
        <div class="p-8 border-b border-slate-100 flex justify-between items-start">
            <div>
                <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Purchase Request Detail</span>
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mt-1">{{ $pr->pr_number }}</h1>
                <p class="text-slate-500 font-medium text-sm mt-1">Requested by: {{ $pr->user->name }} on {{ $pr->request_date->format('d M Y') }}</p>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest block mb-2">Current Status</span>
                <span class="px-4 py-2 rounded-full border text-xs font-black uppercase bg-slate-50">
                    {{ $pr->status }}
                </span>
            </div>
        </div>

        <div class="p-8">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="py-4 border-b border-slate-100">Product Name</th>
                        <th class="py-4 border-b border-slate-100 text-center">Quantity</th>
                        <th class="py-4 border-b border-slate-100 text-right">Unit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($pr->items as $item)
                    <tr>
                        <td class="py-4 font-bold text-slate-700">{{ $item->product->name }}</td>
                        <td class="py-4 text-center font-black text-slate-900">{{ number_format($item->qty) }}</td>
                        <td class="py-4 text-right text-slate-500 font-medium uppercase text-xs">{{ $item->unit_name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($pr->note)
            <div class="mt-8 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Notes</h4>
                <p class="text-sm text-slate-600 font-medium leading-relaxed">{{ $pr->note }}</p>
            </div>
            @endif
        </div>

        {{-- Approval Buttons --}}
        @if($pr->status === 'PENDING')
        <div class="p-8 bg-slate-50 border-t border-slate-100 flex gap-4">
            <form action="{{ route('purchase-requests.update-status', $pr->id) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="APPROVED">
                <button type="submit" class="w-full py-4 bg-emerald-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition-all">
                    Approve Request
                </button>
            </form>
            
            <button onclick="document.getElementById('modal-reject').classList.remove('hidden')" class="flex-1 py-4 bg-white border border-rose-200 text-rose-600 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-rose-50 transition-all">
                Reject Request
            </button>
        </div>
        @endif
    </div>
</div>

{{-- Modal Reject --}}
<div id="modal-reject" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-[2rem] max-w-md w-full p-8 shadow-2xl">
        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter mb-4">Reject Request?</h3>
        <form action="{{ route('purchase-requests.update-status', $pr->id) }}" method="POST">
            @csrf @method('PATCH')
            <input type="hidden" name="status" value="REJECTED">
            <textarea name="reason" required class="w-full rounded-2xl border-slate-200 focus:ring-rose-500 min-h-[100px] mb-6 p-4" placeholder="Berikan alasan penolakan..."></textarea>
            
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('modal-reject').classList.add('hidden')" class="flex-1 py-3 text-xs font-black uppercase text-slate-400">Batal</button>
                <button type="submit" class="flex-1 py-3 bg-rose-600 text-white rounded-xl font-black text-xs uppercase tracking-widest">Ya, Tolak</button>
            </div>
        </form>
    </div>
</div>
@endsection