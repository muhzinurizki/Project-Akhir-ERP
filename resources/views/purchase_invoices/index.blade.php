@extends('layouts.app')

@section('title', 'Account Payable | ERP Tekstil')

@section('content')
<div class="max-w-7xl mx-auto p-8 pb-20">
    
    {{-- Notifikasi Sukses --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-[2rem] flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
            <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white">
                <i data-lucide="check" class="w-4 h-4"></i>
            </div>
            <p class="text-[11px] font-black uppercase text-emerald-700 tracking-widest">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Summary Header --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl shadow-slate-200 group hover:-translate-y-1 transition-all duration-500">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Total Outstanding Debt</p>
            <h3 class="text-3xl font-black tracking-tighter italic">Rp {{ number_format($stats['total_ap'], 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center gap-2 text-emerald-400">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                <span class="text-[10px] font-bold uppercase tracking-widest uppercase">Verified Liability</span>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 border border-slate-100 shadow-sm group hover:-translate-y-1 transition-all duration-500">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-rose-500 mb-2">Critical Overdue</p>
            <h3 class="text-3xl font-black tracking-tighter text-slate-900 italic">{{ $stats['overdue_count'] }} <span class="text-sm font-medium text-slate-400 uppercase tracking-widest italic">Invoices</span></h3>
            <p class="mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">Requires Immediate Payout</p>
        </div>

        <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-100 group hover:-translate-y-1 transition-all duration-500">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-200 mb-2">Upcoming 7 Days</p>
            <h3 class="text-3xl font-black tracking-tighter italic">Rp {{ number_format($stats['upcoming_payment'], 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <i data-lucide="calendar-clock" class="w-4 h-4 text-indigo-300"></i>
                <span class="text-[10px] font-bold uppercase tracking-widest text-indigo-100">Projected Cash Outflow</span>
            </div>
        </div>
    </div>

    {{-- Main Table Section --}}
    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/30">
            <div>
                <h2 class="text-xl font-black text-slate-900 tracking-tighter uppercase italic">Account Payable Ledger</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Manajemen Hutang Dagang & Supplier</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('purchase-invoices.create') }}" class="flex items-center gap-3 px-8 py-4 bg-slate-900 text-white rounded-[1.5rem] font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 hover:shadow-lg hover:shadow-indigo-100 transition-all active:scale-95">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Add New Invoice
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] bg-white">
                        <th class="px-8 py-6">Vendor & Reference</th>
                        <th class="px-6 py-6 text-center">Maturity Date</th>
                        <th class="px-6 py-6 text-right">Total Invoice</th>
                        <th class="px-6 py-6 text-right">Remaining Balance</th>
                        <th class="px-6 py-6 text-center">Payment Status</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($invoices as $inv)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-800 uppercase tracking-tighter group-hover:text-indigo-600 transition-colors">{{ $inv->supplier->name }}</span>
                                <span class="text-[10px] font-mono font-bold text-slate-400 tracking-widest mt-0.5 italic">Ref No. {{ $inv->invoice_number }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-center">
                            @php 
                                $isOverdue = $inv->due_date < now() && $inv->status != 'paid';
                            @endphp
                            <div class="inline-flex flex-col items-center">
                                <span class="text-xs font-black {{ $isOverdue ? 'text-rose-600 bg-rose-50 px-2 py-1 rounded-lg' : 'text-slate-600' }}">
                                    {{ $inv->due_date->format('d M, Y') }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-6 text-right font-bold text-slate-400 text-xs">
                            Rp {{ number_format($inv->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-6 text-right font-black text-slate-900 text-sm italic">
                            Rp {{ number_format($inv->total_amount - $inv->paid_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-6 text-center">
                            @php
                                $statusClasses = [
                                    'paid' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'partial' => 'bg-amber-50 text-amber-600 border-amber-100',
                                    'unpaid' => 'bg-slate-50 text-slate-400 border-slate-100',
                                    'overdue' => 'bg-rose-50 text-rose-600 border-rose-100',
                                ];
                            @endphp
                            <span class="px-3 py-1.5 rounded-xl border {{ $statusClasses[$inv->status] ?? $statusClasses['unpaid'] }} text-[9px] font-black uppercase tracking-[0.15em]">
                                {{ $inv->status }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('purchase-invoices.edit', $inv) }}" class="p-2.5 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-amber-500 hover:border-amber-100 transition-all shadow-sm">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('purchase-invoices.destroy', $inv) }}" method="POST" class="inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(this)" class="p-2.5 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-rose-500 hover:border-rose-100 transition-all shadow-sm">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center text-slate-200 mb-4">
                                    <i data-lucide="inbox" class="w-10 h-10"></i>
                                </div>
                                <h3 class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">No Invoices Found</h3>
                                <p class="text-xs text-slate-300 mt-1">Start by adding your first supplier bill.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-8 bg-slate-50/30 border-t border-slate-50">
            {{ $invoices->links() }}
        </div>
    </div>
</div>

{{-- SweetAlert2 for Delete Confirmation --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'TERMINATE INVOICE?',
            text: "This action cannot be undone in the ledger!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0f172a', // slate-900
            cancelButtonColor: '#f43f5e',  // rose-500
            confirmButtonText: 'YES, DELETE',
            cancelButtonText: 'CANCEL',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl font-black text-[10px] uppercase tracking-widest px-6 py-4',
                cancelButton: 'rounded-xl font-black text-[10px] uppercase tracking-widest px-6 py-4'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }
</script>
@endpush
@endsection