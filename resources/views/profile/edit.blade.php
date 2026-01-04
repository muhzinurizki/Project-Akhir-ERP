@extends('layouts.app')

@section('title', 'User Profile')
@section('page-title', 'Account Settings')

@section('content')
<div class="max-w-5xl mx-auto pb-20">

    {{-- Header Section --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div>
            <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                <i data-lucide="user-cog" class="w-3 h-3"></i>
                <span>Account</span>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                <span class="text-slate-900">Settings</span>
            </nav>
            <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Profil Pengguna</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Kelola informasi akun, keamanan password, dan preferensi
                sistem Anda.</p>
        </div>

        <div class="flex items-center gap-3 px-6 py-4 bg-white rounded-3xl border border-slate-100 shadow-sm">
            <div
                class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-100">
                <span class="text-xl font-black">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            <div>
                <p class="text-sm font-black text-slate-900 leading-none">{{ auth()->user()->name }}</p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter mt-1">{{ auth()->user()->role
                    ?? 'Staff' }} • ID #{{ auth()->user()->id }}</p>
            </div>
        </div>
    </div>

    <div class="space-y-8">

        {{-- 1. Personal Information --}}
        <div
            class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500">
            <div class="p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div
                        class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                        <i data-lucide="user" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Informasi Pribadi</h3>
                        <p class="text-xs text-slate-400 font-medium tracking-tight">Update nama akun dan alamat email
                            terdaftar Anda.</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        {{-- 2. Security / Password --}}
        <div
            class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden group hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500">
            <div class="p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div
                        class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-amber-500 group-hover:text-white transition-all">
                        <i data-lucide="shield-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Keamanan Akun</h3>
                        <p class="text-xs text-slate-400 font-medium tracking-tight">Pastikan akun Anda menggunakan
                            password panjang yang aman.</p>
                    </div>
                </div>

                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        {{-- 3. Danger Zone --}}
        <div
            class="bg-rose-50/30 rounded-[2.5rem] border border-rose-100/50 shadow-sm overflow-hidden group transition-all duration-500">
            <div class="p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600">
                        <i data-lucide="alert-octagon" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-rose-900 uppercase tracking-tighter">Zona Berbahaya</h3>
                        <p class="text-xs text-rose-400 font-medium tracking-tight">Penghapusan akun bersifat permanen
                            dan tidak dapat dibatalkan.</p>
                    </div>
                </div>

                <div class="max-w-xl bg-white p-8 rounded-3xl border border-rose-100">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>

    </div>
</div>
@endsection