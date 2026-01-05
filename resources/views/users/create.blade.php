@extends('layouts.app')

@section('title', 'Register Member | ERP Tekstil')

@section('content')
<div class="max-w-5xl mx-auto p-8 pb-20">
    
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

    <form method="POST" action="{{ route('users.store') }}" class="space-y-8" id="regForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Main Form Column --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Account Profile Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Personal Information</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Name --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Name</label>
                            <div class="relative group">
                                <i data-lucide="user" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Alexander Pierce" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('name') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Phone Number</label>
                            <div class="relative group">
                                <i data-lucide="phone" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0812xxxx" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('phone') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Access Identifiers Card (Username & NIK) --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Access Identifiers</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Work Email</label>
                            <div class="relative group">
                                <i data-lucide="mail" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="name@company.com" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('email') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Username --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">System Username</label>
                            <div class="relative group">
                                <i data-lucide="at-sign" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="username" value="{{ old('username') }}" placeholder="alexpierce" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('username') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Employee Code (NIK) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Employee Code (NIK)</label>
                            <div class="relative group">
                                <i data-lucide="fingerprint" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="employee_code" value="{{ old('employee_code', 'EMP-' . date('Y') . '-' . Str::upper(Str::random(4))) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-black text-indigo-600 shadow-inner tracking-widest">
                            </div>
                            <p class="text-[9px] text-slate-400 font-medium ml-1">*Kode dihasilkan otomatis, Anda dapat menyesuaikannya jika perlu.</p>
                        </div>
                    </div>
                </div>

                {{-- Security Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-slate-900 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Security Credentials</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Password</label>
                            <input type="password" name="password" required
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Confirm Password</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-6 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Column: Roles --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 sticky top-8">
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

                            <div class="w-6 h-6 rounded-full flex items-center justify-center bg-slate-100 text-slate-300 group-has-[:checked]:bg-white/20 group-has-[:checked]:text-white">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <div class="mt-8 space-y-4">
                        <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-800 transition-all flex items-center justify-center gap-3">
                            <i data-lucide="user-plus" class="w-4 h-4"></i>
                            Finalize Account
                        </button>
                        <a href="{{ route('users.index') }}" class="block text-center text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Cancel Process</a>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection