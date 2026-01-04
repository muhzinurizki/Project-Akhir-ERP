@extends('layouts.app')

@section('title', 'User Profile | ERP Tekstil')
@section('page-title', 'Account Settings')

@section('content')
<div class="max-w-5xl mx-auto pb-20 px-4 sm:px-6">

    {{-- Header Section --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3">
                <i data-lucide="user-cog" class="w-3.5 h-3.5"></i>
                <span>Account Management</span>
                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                <span class="text-indigo-600">Profile Settings</span>
            </nav>
            <h2 class="text-4xl font-black text-slate-900 tracking-tighter">Profil Pengguna</h2>
            <p class="text-slate-500 font-medium mt-2 max-w-md">Konfigurasi identitas digital, protokol keamanan, dan kontrol akses akun personal Anda.</p>
        </div>

        <div class="flex items-center gap-4 px-6 py-4 bg-white rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/40">
            <div class="relative group">
                <div class="w-14 h-14 rounded-2xl bg-slate-900 flex items-center justify-center text-white shadow-lg transition-transform group-hover:rotate-3">
                    <span class="text-2xl font-black italic">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-4 border-white rounded-full"></div>
            </div>
            <div>
                <p class="text-sm font-black text-slate-900 leading-tight">{{ auth()->user()->name }}</p>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase rounded-md tracking-widest border border-indigo-100">
                        {{ auth()->user()->roles->first()->name ?? 'Staff' }}
                    </span>
                    <span class="text-[10px] font-bold text-slate-300 tracking-tighter">#{{ auth()->user()->id }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-10">

        {{-- 1. Personal Information --}}
        <section class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden group transition-all duration-500 hover:border-indigo-100">
            <div class="p-8 md:p-12">
                <div class="flex items-start justify-between mb-10">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-inner">
                            <i data-lucide="fingerprint" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase italic">Informasi Profil</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Identitas Dasar Akun</p>
                        </div>
                    </div>
                </div>

                <div class="max-w-2xl bg-slate-50/50 p-8 rounded-[2rem] border border-slate-50">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </section>

        {{-- 2. Security / Password --}}
        <section class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden group transition-all duration-500 hover:border-amber-100">
            <div class="p-8 md:p-12">
                <div class="flex items-start justify-between mb-10">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-all duration-500 shadow-inner">
                            <i data-lucide="key-round" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-black text-slate-900 tracking-tight uppercase italic">Keamanan Siber</h3>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Enkripsi & Akses Password</p>
                        </div>
                    </div>
                </div>

                <div class="max-w-2xl bg-slate-50/50 p-8 rounded-[2rem] border border-slate-50">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </section>

        {{-- 3. Danger Zone --}}
        <section class="bg-rose-50/20 rounded-[3rem] border border-rose-100/40 overflow-hidden transition-all duration-500">
            <div class="p-8 md:p-12">
                <div class="flex items-center gap-5 mb-10">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center animate-pulse">
                        <i data-lucide="shield-alert" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-rose-900 tracking-tight uppercase italic">Privasi & Terminasi</h3>
                        <p class="text-xs text-rose-400 font-bold uppercase tracking-widest mt-1">Tindakan Tidak Dapat Dibatalkan</p>
                    </div>
                </div>

                <div class="max-w-2xl bg-white p-8 rounded-[2rem] border border-rose-100 shadow-sm">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </section>

    </div>
</div>
@endsection