@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Purchase Requests</h1>
            <p class="text-sm text-slate-500 font-medium">Monitoring status permintaan barang Anda.</p>
        </div>
        <a href="{{ route('purchase-requests.create') }}" class="bg-slate-900 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-800 transition-all shadow-xl shadow-slate-200">
            Buat PR Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-600 rounded-2xl text-sm font-bold">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">No. PR</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Tanggal</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Status</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($prs as $pr)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 font-black text-slate-900 uppercase">{{ $pr->pr_number }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-500">{{ $pr->request_date->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $badge = [
                                'PENDING' => 'bg-amber-50 text-amber-600 border-amber-200',
                                'APPROVED' => 'bg-emerald-50 text-emerald-600 border-emerald-200',
                                'REJECTED' => 'bg-rose-50 text-rose-600 border-rose-200'
                            ][$pr->status] ?? 'bg-slate-50 text-slate-600 border-slate-200';
                        @endphp
                        <span class="px-3 py-1 rounded-full border text-[10px] font-black uppercase {{ $badge }}">
                            {{ $pr->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('purchase-requests.show', $pr->id) }}" class="text-indigo-600 hover:text-indigo-900 font-black text-[10px] uppercase tracking-widest">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-20 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">Belum ada data dokumen.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $prs->links() }}
    </div>
</div>
@endsection