@extends('layouts.app')

@section('title', 'Tambah Supplier')
@section('page-title', 'Purchasing')

@section('content')
<div class="max-w-5xl mx-auto pb-20">
  {{-- Navigation --}}
  <div class="mb-8 flex items-center justify-between">
    <a href="{{ route('suppliers.index') }}"
      class="group flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">
      <div
        class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:border-slate-900 transition-all shadow-sm">
        <i data-lucide="arrow-left" class="w-4 h-4"></i>
      </div>
      Kembali ke Daftar Vendor
    </a>
  </div>

  <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden">
    {{-- Header Form --}}
    <div class="px-10 py-8 border-b border-slate-50 bg-slate-50/30 flex justify-between items-center">
      <div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Registrasi Supplier Baru</h2>
        <p class="text-sm text-slate-500 font-medium mt-1">Pastikan data legalitas dan kontak supplier valid untuk
          keperluan PO & Invoice.</p>
      </div>
      <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200">
        <i data-lucide="building-2" class="w-8 h-8 text-white"></i>
      </div>
    </div>

    <form method="POST" action="{{ route('suppliers.store') }}" class="p-10 space-y-10">
      @csrf

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        {{-- Kiri: Informasi Legal & Identitas --}}
        <div class="lg:col-span-7 space-y-8">
          <div class="space-y-6">
            <div class="flex items-center gap-3">
              <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">01. Identitas Legal</h3>
              <div class="h-px flex-1 bg-slate-100"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Kode Vendor</label>
                <input name="code" value="{{ old('code') }}" placeholder="SUPP-001"
                  class="w-full px-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              </div>
              <div class="space-y-2">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Nama
                  Perusahaan/Vendor</label>
                <input name="name" value="{{ old('name') }}" placeholder="PT. Tekstil Maju Jaya"
                  class="w-full px-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm">
              </div>
            </div>

            <div class="space-y-2">
              <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Alamat Kantor /
                NPWP</label>
              <textarea name="address" rows="3" placeholder="Jl. Kawasan Industri No. 12..."
                class="w-full px-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all shadow-sm"></textarea>
            </div>
          </div>

          <div class="space-y-6">
            <div class="flex items-center gap-3">
              <h3 class="text-[11px] font-black text-indigo-600 uppercase tracking-[0.2em]">02. Financial Setting</h3>
              <div class="h-px flex-1 bg-slate-100"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div class="space-y-2 text-slate-900">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Term of
                  Payment</label>
                <select name="term_of_payment"
                  class="w-full px-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer">
                  <option value="COD">Cash on Delivery</option>
                  <option value="NET7">Net 7 Days</option>
                  <option value="NET30">Net 30 Days</option>
                  <option value="NET60">Net 60 Days</option>
                </select>
              </div>
              <div class="space-y-2 text-slate-900">
                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 ml-1">Mata Uang</label>
                <select name="currency"
                  class="w-full px-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl text-sm font-bold focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:border-indigo-600 outline-none transition-all appearance-none cursor-pointer">
                  <option value="IDR">IDR - Indonesian Rupiah</option>
                  <option value="USD">USD - US Dollar</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        {{-- Kanan: Person in Charge --}}
        <div class="lg:col-span-5 space-y-8">
          <div class="bg-slate-50 rounded-[2rem] p-8 space-y-6 border border-slate-100">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shadow-sm">
                <i data-lucide="user" class="w-4 h-4 text-indigo-600"></i>
              </div>
              <h3 class="text-[11px] font-black text-slate-900 uppercase tracking-widest">Contact Person</h3>
            </div>

            <div class="space-y-4">
              <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-slate-400 ml-1">Nama PIC</label>
                <input name="contact_person" placeholder="Nama Lengkap"
                  class="w-full px-4 py-3 border-transparent rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-600 outline-none transition-all shadow-sm">
              </div>
              <div class="space-y-1.5 text-slate-900">
                <label class="text-[10px] font-bold text-slate-400 ml-1">No. WhatsApp/Telepon</label>
                <input name="phone" placeholder="0812xxxx"
                  class="w-full px-4 py-3 border-transparent rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-600 outline-none transition-all shadow-sm">
              </div>
              <div class="space-y-1.5 text-slate-900">
                <label class="text-[10px] font-bold text-slate-400 ml-1">Email Bisnis</label>
                <input name="email" type="email" placeholder="vendor@email.com"
                  class="w-full px-4 py-3 border-transparent rounded-xl text-sm font-bold focus:ring-2 focus:ring-indigo-600 outline-none transition-all shadow-sm">
              </div>
            </div>

            <div class="pt-4 border-t border-slate-200/50">
              <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                <div
                  class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600">
                </div>
                <span class="ml-3 text-xs font-bold text-slate-700">Set as Active Partner</span>
              </label>
            </div>
          </div>
        </div>
      </div>

      {{-- Action Buttons --}}
      <div class="flex items-center justify-end gap-4 pt-10 border-t border-slate-50">
        <a href="{{ route('suppliers.index') }}"
          class="px-8 py-4 text-sm font-bold text-slate-400 hover:text-slate-900 transition-all">Batal</a>
        <button type="submit"
          class="px-12 py-4 bg-slate-900 text-white text-sm font-bold rounded-2xl hover:bg-slate-800 shadow-xl shadow-slate-200 transition-all flex items-center gap-3 active:scale-95">
          <i data-lucide="save" class="w-5 h-5"></i>
          Simpan Data Supplier
        </button>
      </div>
    </form>
  </div>
</div>
@endsection