@extends('layouts.app')

@section('title', 'Inspect Product')
@section('page-title', 'Product Inspection')

@section('content')
<div class="max-w-4xl mx-auto pb-20">

  {{-- Back --}}
  <div class="mb-8">
    <a href="{{ route('qc-inspections.index') }}"
       class="flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition">
      <i data-lucide="arrow-left" class="w-4 h-4"></i>
      Back to Inspection List
    </a>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">

    {{-- Header --}}
    <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30">
      <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
        Quality Inspection
      </h2>
      <p class="text-sm text-slate-500 mt-1">
        Inspect product and record QC result.
      </p>
    </div>

    <form method="POST" action="{{ route('qc-inspections.store') }}" class="p-10 space-y-10">
      @csrf

      <input type="hidden" name="product_id" value="{{ $product->id }}">

        {{-- Product & Inspector Info --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- LEFT : Product Detail --}}
        <div class="md:col-span-2 bg-slate-50/40 border border-slate-100 rounded-2xl p-6 space-y-6">

            <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <i data-lucide="package" class="w-5 h-5"></i>
            </div>
            <h3 class="text-sm font-extrabold uppercase tracking-widest text-slate-700">
                Product Detail
            </h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

            {{-- Product --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Product</p>
                <p class="mt-1 font-extrabold text-slate-900">
                {{ $product->name }}
                </p>
                <p class="text-[10px] text-slate-400 uppercase tracking-widest">
                {{ $product->sku }}
                </p>
            </div>

            {{-- Category --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Category</p>
                <p class="mt-1 font-bold text-slate-700">
                {{ $product->category?->name ?? '-' }}
                </p>
            </div>

            {{-- Unit --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Unit</p>
                <p class="mt-1 font-bold text-slate-700">
                {{ $product->unit?->code ?? '-' }}
                </p>
                <p class="text-[10px] text-slate-400">
                {{ $product->unit?->name ?? '' }}
                </p>
            </div>

            {{-- Type --}}
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Type</p>
                <span
                class="inline-block mt-1 px-3 py-1 rounded-lg text-[10px] font-black
                        bg-white border border-slate-200 uppercase">
                {{ str_replace('_', ' ', $product->type) }}
                </span>
            </div>

            </div>
        </div>

        {{-- RIGHT : Inspector --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-sm">

            <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <i data-lucide="user-check" class="w-5 h-5"></i>
            </div>
            <h3 class="text-sm font-extrabold uppercase tracking-widest text-slate-700">
                Inspector
            </h3>
            </div>

            <div class="space-y-4">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                Name
                </p>
                <p class="mt-1 font-extrabold text-slate-900">
                {{ auth()->user()->name }}
                </p>
            </div>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                Email
                </p>
                <p class="mt-1 text-sm font-medium text-slate-600">
                {{ auth()->user()->email }}
                </p>
            </div>

            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">
                Inspection Date
                </p>
                <p class="mt-1 text-sm font-bold text-slate-700">
                {{ now()->format('d M Y') }}
                </p>
            </div>
            </div>

        </div>
        </div>



      <hr class="border-slate-50">

      {{-- QC Result --}}
      <div class="space-y-4">
        <label class="text-xs font-bold uppercase text-slate-500">
          Inspection Result
        </label>

        <div class="grid grid-cols-2 gap-4">
          <label class="border-2 border-slate-100 rounded-xl p-4 cursor-pointer hover:border-emerald-300">
            <input type="radio" name="status" value="APPROVED" class="hidden peer" required>
            <div class="text-center peer-checked:text-emerald-600 font-bold">
              APPROVED
            </div>
          </label>

          <label class="border-2 border-slate-100 rounded-xl p-4 cursor-pointer hover:border-rose-300">
            <input type="radio" name="status" value="REJECTED" class="hidden peer">
            <div class="text-center peer-checked:text-rose-600 font-bold">
              REJECTED
            </div>
          </label>
        </div>
      </div>

      {{-- Note --}}
      <div class="space-y-2">
        <label class="text-xs font-bold uppercase text-slate-500">
          Note (Required if Rejected)
        </label>
        <textarea name="note" rows="4"
          class="w-full bg-slate-50 border border-slate-100 rounded-xl p-4 text-sm focus:bg-white focus:border-slate-900 outline-none transition"></textarea>
      </div>

      {{-- Actions --}}
      <div class="flex justify-end gap-4 pt-6">
        <a href="{{ route('qc-inspections.index') }}"
           class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-slate-900">
          Cancel
        </a>
        <button type="submit"
          class="px-8 py-3 bg-slate-900 text-white rounded-xl font-bold hover:bg-slate-800 transition">
          Save Inspection
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
