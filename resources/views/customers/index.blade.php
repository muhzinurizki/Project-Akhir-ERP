@extends('layouts.app')

@section('title', 'Customers | ERP Tekstil')

@section('content')
<div class="max-w-7xl mx-auto p-4 sm:p-8 pb-20">
    
    {{-- Notifikasi Modern --}}
    @if(session('success'))
        <div class="mb-8 p-5 bg-slate-900 rounded-[2rem] flex items-center justify-between group animate-in fade-in slide-in-from-top-4 duration-700 shadow-2xl shadow-indigo-100">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                    <i data-lucide="check" class="w-5 h-5"></i>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em]">System Notification</p>
                    <p class="text-xs font-bold text-white tracking-wide">{{ session('success') }}</p>
                </div>
            </div>
            <button class="text-slate-500 hover:text-white transition-colors px-4">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    @endif

    {{-- Header Section --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 bg-white border border-slate-100 rounded-[2.5rem] shadow-xl flex items-center justify-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-slate-900 translate-y-20 group-hover:translate-y-0 transition-transform duration-500"></div>
                <i data-lucide="users" class="w-10 h-10 text-slate-900 group-hover:text-white transition-colors duration-500 relative z-10"></i>
            </div>
            <div>
                <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">Customer <span class="text-indigo-600">Hub</span></h1>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em] mt-3 flex items-center gap-2">
                    <span class="w-8 h-[2px] bg-indigo-600"></span>
                    Centralized Partner Database
                </p>
            </div>
        </div>
        
        <div class="flex items-center gap-4">
            <div class="hidden sm:flex flex-col items-end mr-2">
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Total Partners</p>
                <p class="text-xl font-black text-slate-900 italic">{{ $customers->total() }}</p>
            </div>
            <a href="{{ route('customers.create') }}" class="group flex items-center gap-4 px-10 py-5 bg-slate-900 text-white rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all duration-500 shadow-2xl shadow-slate-200 hover:shadow-indigo-200 active:scale-95">
                <i data-lucide="user-plus" class="w-5 h-5 group-hover:rotate-12 transition-transform"></i>
                Register New Customer
            </a>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-[3.5rem] border border-slate-100 shadow-[0_30px_60px_-15px_rgba(0,0,0,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-[0.25em] bg-slate-50/50 border-b border-slate-50">
                        <th class="px-10 py-8">Partner Identity</th>
                        <th class="px-8 py-8">Connectivity</th>
                        <th class="px-8 py-8">Geographic Info</th>
                        <th class="px-10 py-8 text-right">Operations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($customers as $customer)
                    <tr class="group hover:bg-slate-50/80 transition-all duration-300">
                        <td class="px-10 py-8">
                            <div class="flex items-center gap-5">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center text-slate-400 group-hover:bg-white group-hover:border-indigo-100 group-hover:text-indigo-600 transition-all duration-500 shadow-sm">
                                    <span class="text-[10px] font-black tracking-tighter leading-none mb-1 text-slate-300 uppercase italic">ID</span>
                                    <span class="text-xs font-black leading-none italic">{{ str_pad($customer->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-base font-black text-slate-900 uppercase tracking-tight group-hover:text-indigo-600 transition-colors">{{ $customer->name }}</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-200"></span>
                                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.1em]">Active Partner</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8">
                            <div class="flex flex-col gap-1.5">
                                <div class="flex items-center gap-2 text-slate-600 group-hover:text-slate-900 transition-colors">
                                    <i data-lucide="phone" class="w-3.5 h-3.5 text-slate-300"></i>
                                    <span class="text-xs font-mono font-black tracking-tighter">{{ $customer->contact ?? '+62 ---' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-slate-400">
                                    <i data-lucide="mail" class="w-3.5 h-3.5 text-slate-300"></i>
                                    <span class="text-[10px] font-bold italic">{{ $customer->email ?? 'no-email@partner.com' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-8">
                            <div class="flex items-start gap-3 max-w-xs">
                                <div class="p-2 rounded-lg bg-slate-50 text-slate-300 group-hover:bg-white group-hover:text-indigo-300 transition-all shadow-sm mt-1">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                </div>
                                <p class="text-[11px] text-slate-500 font-bold leading-relaxed italic">
                                    {{ $customer->address ?? 'Warehouse address not specified in database.' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-10 py-8 text-right">
                            <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 translate-x-4 group-hover:translate-x-0 transition-all duration-500">
                                <a href="{{ route('customers.edit', $customer) }}" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-amber-500 hover:border-amber-200 hover:shadow-xl hover:shadow-amber-500/10 flex items-center justify-center transition-all">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-10 h-10 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-rose-500 hover:border-rose-200 hover:shadow-xl hover:shadow-rose-500/10 flex items-center justify-center transition-all" onclick="return confirm('Hapus partner ini dari database?')">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-32 text-center bg-slate-50/20 italic">
                            <div class="max-w-xs mx-auto flex flex-col items-center">
                                <div class="w-24 h-24 bg-white rounded-[2.5rem] flex items-center justify-center text-slate-100 mb-8 shadow-2xl shadow-slate-200 relative">
                                    <i data-lucide="database-zap" class="w-12 h-12"></i>
                                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-slate-900 rounded-full flex items-center justify-center text-white text-[10px] font-black italic">!</div>
                                </div>
                                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter italic">Data Obscure</h3>
                                <p class="text-[10px] text-slate-400 mt-2 font-black uppercase tracking-[0.2em] leading-relaxed">Sistem belum mendeteksi entitas partner terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Custom Pagination Styling --}}
        @if($customers->hasPages())
        <div class="px-10 py-8 bg-slate-50/50 border-t border-slate-50">
            <div class="flex justify-between items-center italic">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                    Browsing Phase {{ $customers->currentPage() }} of {{ $customers->lastPage() }}
                </span>
                {{ $customers->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    /* Custom CSS for even cleaner UI */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;  
        overflow: hidden;
    }
</style>
@endsection