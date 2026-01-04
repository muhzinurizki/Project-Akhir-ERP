@extends('layouts.app')

@section('title', 'Create New User | ERP Tekstil')

@section('content')
<div class="max-w-4xl mx-auto p-8 pb-20">
    
    {{-- Header Section --}}
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" 
               class="p-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm group">
                <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">Register Member</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Daftarkan personil baru ke dalam ekosistem sistem.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('users.store') }}" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Main Form Column --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Account Profile Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Account Profile</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Name</label>
                            <div class="relative group">
                                <i data-lucide="user" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Alexander Pierce" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('name') <p class="text-rose-500 text-[10px] font-bold uppercase mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Work Email</label>
                            <div class="relative group">
                                <i data-lucide="mail" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('email') <p class="text-rose-500 text-[10px] font-bold uppercase mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Security Credentials Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-slate-900 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Security Credentials</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Password</label>
                            <div class="relative group">
                                <i data-lucide="lock" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="password" name="password" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('password') <p class="text-rose-500 text-[10px] font-bold uppercase mt-2 ml-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm Password</label>
                            <div class="relative group">
                                <i data-lucide="shield-check" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="password" name="password_confirmation" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column: Roles --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Assign Privileges</h3>
                    
                    <div class="space-y-3">
                        @foreach($roles as $role)
                        <label class="relative flex items-center justify-between p-4 rounded-2xl cursor-pointer border-2 transition-all duration-300 group
                            has-[:checked]:bg-indigo-600 has-[:checked]:border-indigo-600 has-[:checked]:shadow-lg has-[:checked]:shadow-indigo-100 bg-white border-slate-100 hover:border-indigo-200">
                            
                            <input type="radio" name="role" value="{{ $role->name }}" class="hidden" 
                                {{ old('role') == $role->name ? 'checked' : '' }} required>
                            
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 group-has-[:checked]:text-indigo-100">Role Access</span>
                                <span class="text-sm font-black text-slate-700 uppercase tracking-tighter group-has-[:checked]:text-white">{{ $role->name }}</span>
                            </div>

                            <div class="w-6 h-6 rounded-full flex items-center justify-center bg-slate-100 text-slate-300 group-has-[:checked]:bg-white/20 group-has-[:checked]:text-white transition-colors">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('role') <p class="text-rose-500 text-[10px] font-bold uppercase mt-4 text-center tracking-tight">{{ $message }}</p> @enderror
                </div>

                {{-- Submit Action --}}
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-5 bg-indigo-600 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="user-plus" class="w-4 h-4"></i>
                        Register User
                    </button>
                    <p class="text-[10px] text-center text-slate-400 font-bold uppercase tracking-widest px-6">
                        Pastikan email yang didaftarkan adalah email aktif perusahaan.
                    </p>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection