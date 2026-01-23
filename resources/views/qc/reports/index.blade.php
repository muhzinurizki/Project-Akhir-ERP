@extends('layouts.app')

@section('title', 'QC Reports')
@section('page-title', 'Quality Control')

@section('content')
<div class="space-y-8">

  {{-- Header --}}
  <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
    <div>
      <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
        <span>Quality Control</span>
        <i data-lucide="chevron-right" class="w-3 h-3"></i>
        <span class="text-slate-900">QC Reports</span>
      </nav>
      <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">
        QC Reports
      </h2>
      <p class="text-sm text-slate-500 font-medium mt-1">
        Summary of quality control inspection results.
      </p>
    </div>

    <div class="flex items-center gap-3">
      <button
        class="flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 text-slate-700
               rounded-xl text-sm font-bold hover:bg-slate-50 transition shadow-sm">
        <a
            href="{{ route('qc-reports.export', request()->query()) }}"
            class="inline-flex items-center gap-2">
            <i data-lucide="file-down" class="w-4 h-4"></i>
            Export Excel
        </a>

      </button>
    </div>
  </div>

  {{-- Table Card --}}
  <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">

    {{-- Filter Bar --}}
    <form method="GET"
          action="{{ route('qc-reports.index') }}"
          class="p-6 border-b border-slate-50 bg-slate-50/30 grid grid-cols-1 md:grid-cols-5 gap-4">

      {{-- Date --}}
      <input type="date" name="date"
        value="{{ request('date') }}"
        class="bg-white border border-slate-200 rounded-xl text-sm px-4 py-2.5">

      {{-- Status --}}
      <select name="status"
        class="bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 px-4 py-2.5">
        <option value="">All Status</option>
        <option value="APPROVED" @selected(request('status') == 'APPROVED')>APPROVED</option>
        <option value="REJECTED" @selected(request('status') == 'REJECTED')>REJECTED</option>
      </select>

      {{-- Product --}}
      <input type="text" name="product"
        value="{{ request('product') }}"
        placeholder="Product / SKU"
        class="bg-white border border-slate-200 rounded-xl text-sm px-4 py-2.5">

      {{-- Inspector --}}
      <input type="text" name="inspector"
        value="{{ request('inspector') }}"
        placeholder="Inspector"
        class="bg-white border border-slate-200 rounded-xl text-sm px-4 py-2.5">

      {{-- Action --}}
      <div class="flex gap-2">
        <button type="submit"
          class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800 transition">
          Filter
        </button>

        @if(request()->anyFilled(['date','status','product','inspector']))
        <a href="{{ route('qc-reports.index') }}"
           class="px-4 py-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-100 transition">
          <i data-lucide="x-circle" class="w-5 h-5"></i>
        </a>
        @endif
      </div>
    </form>

    {{-- Table --}}
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-white text-slate-400 uppercase text-[10px] font-bold tracking-widest">
          <tr>
            <th class="px-8 py-5 text-center w-16">#</th>
            <th class="px-6 py-5">Product</th>
            <th class="px-6 py-5">Category</th>
            <th class="px-6 py-5 text-center">Unit</th>
            <th class="px-6 py-5">Inspector</th>
            <th class="px-6 py-5 text-center">Status</th>
            <th class="px-6 py-5">Inspection Date</th>
            <th class="px-6 py-5 text-center">Action</th>
          </tr>
        </thead>

        <tbody class="divide-y divide-slate-50">
          @forelse($inspections as $inspection)
          <tr class="hover:bg-slate-50/50 transition">
            <td class="px-8 py-5 text-center font-bold text-slate-300">
              {{ $loop->iteration }}
            </td>

            <td class="px-6 py-5">
              <div class="font-bold text-slate-900">
                {{ $inspection->product->name }}
              </div>
              <div class="text-[10px] text-slate-400 uppercase tracking-widest">
                {{ $inspection->product->sku }}
              </div>
            </td>

            <td class="px-6 py-5 font-bold text-slate-600">
              {{ $inspection->product->category?->name ?? '-' }}
            </td>

            <td class="px-6 py-5 text-center font-bold text-slate-500">
              {{ $inspection->product->unit?->code ?? '-' }}
            </td>

            <td class="px-6 py-5 font-medium text-slate-700">
              {{ $inspection->inspector->name }}
            </td>

            <td class="px-6 py-5 text-center">
              @if($inspection->status === 'APPROVED')
                <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600
                             text-[10px] font-black border border-emerald-100">
                  APPROVED
                </span>
              @else
                <span class="px-3 py-1 rounded-full bg-rose-50 text-rose-600
                             text-[10px] font-black border border-rose-100">
                  REJECTED
                </span>
              @endif
            </td>

            <td class="px-6 py-5 text-sm font-medium text-slate-600">
              {{ $inspection->created_at->format('d M Y') }}
            </td>
            <td class="px-6 py-5 text-center">
                <button
                    onclick="openQcModal({{ $inspection->id }})"
                    class="p-2 rounded-xl bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition"
                    title="View Detail">
                    <i data-lucide="eye" class="w-4 h-4"></i>
                </button>
            </td>
          </tr>
          @empty

          <tr>
            <td colspan="7" class="px-8 py-20 text-center text-slate-400 italic">
              No QC inspection data found.
            </td>
          </tr>
          
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/20">
      {{ $inspections->links() }}
    </div>

  </div>
</div>

{{-- QC Detail Modal --}}
<div id="qcModal"
     class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden items-center justify-center z-50">

  <div class="bg-white w-full max-w-3xl rounded-2xl shadow-xl overflow-hidden">

    {{-- Header --}}
    <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center">
      <h3 class="text-lg font-extrabold text-slate-900">
        QC Inspection Detail
      </h3>
      <button onclick="closeQcModal()" class="text-slate-400 hover:text-slate-900">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    {{-- Content --}}
    <div id="qcModalContent" class="p-8 space-y-6 text-sm">
      {{-- Injected by JS --}}
    </div>

    {{-- Footer --}}
    <div class="px-8 py-4 bg-slate-50 text-right">
      <button onclick="closeQcModal()"
              class="px-6 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-bold hover:bg-slate-800">
        Close
      </button>
    </div>

  </div>
</div>
<script>
  const qcData = @json($inspections->items());

  function openQcModal(id) {
    const qc = qcData.find(item => item.id === id);

    let statusBadge = qc.status === 'APPROVED'
      ? `<span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black">APPROVED</span>`
      : `<span class="px-3 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-black">REJECTED</span>`;

    document.getElementById('qcModalContent').innerHTML = `
      <div class="grid grid-cols-2 gap-6">

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-400">Product</p>
          <p class="font-bold text-slate-900">${qc.product.name}</p>
          <p class="text-[10px] text-slate-400 uppercase">${qc.product.sku}</p>
        </div>

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-400">Inspector</p>
          <p class="font-bold text-slate-900">${qc.inspector.name}</p>
        </div>

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-400">Category</p>
          <p class="font-medium text-slate-700">${qc.product.category?.name ?? '-'}</p>
        </div>

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-400">Unit</p>
          <p class="font-medium text-slate-700">${qc.product.unit?.code ?? '-'}</p>
        </div>

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-400">Status</p>
          ${statusBadge}
        </div>

        <div>
          <p class="text-[10px] uppercase font-bold text-slate-400">Inspection Date</p>
          <p class="font-medium text-slate-700">${qc.created_at}</p>
        </div>

        <div class="col-span-2">
          <p class="text-[10px] uppercase font-bold text-slate-400">Note</p>
          <p class="mt-1 text-slate-700">${qc.note ?? '-'}</p>
        </div>

      </div>
    `;

    document.getElementById('qcModal').classList.remove('hidden');
    document.getElementById('qcModal').classList.add('flex');
  }

  function closeQcModal() {
    document.getElementById('qcModal').classList.add('hidden');
    document.getElementById('qcModal').classList.remove('flex');
  }
</script>

@endsection
