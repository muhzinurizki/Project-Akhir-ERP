@extends('layouts.app')

@section('title', 'Edit User | ERP Tekstil')

@section('content')
<div class="max-w-5xl mx-auto p-8 pb-20">
    
    {{-- Navigation Header --}}
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" 
               class="p-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm group">
                <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">Modify Profile</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">Personnel ID: <span class="font-mono text-indigo-600 font-bold tracking-widest">{{ $user->employee_code }}</span></p>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-3 px-5 py-2.5 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="w-2 h-2 rounded-full {{ $user->is_active ? 'bg-emerald-500' : 'bg-rose-500' }} animate-pulse"></div>
            <span class="text-[10px] font-black text-slate-700 uppercase tracking-widest">
                Account {{ $user->is_active ? 'Active' : 'Suspended' }}
            </span>
        </div>
    </div>

    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Left Side: Identity & Credentials --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Personal Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Personal Identification</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Name --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Name</label>
                            <div class="relative group">
                                <i data-lucide="user" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('name') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Phone --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Phone Number</label>
                            <div class="relative group">
                                <i data-lucide="phone" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Access Card --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">System Identifiers</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Email --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Email Address</label>
                            <div class="relative group">
                                <i data-lucide="mail" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('email') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Username --}}
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Username</label>
                            <div class="relative group">
                                <i data-lucide="at-sign" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('username') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}</p> @enderror
                        </div>

                        {{-- Employee Code (NIK) --}}
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Employee Code (NIK)</label>
                            <div class="relative group">
                                <i data-lucide="fingerprint" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="employee_code" value="{{ old('employee_code', $user->employee_code) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-black text-indigo-600 tracking-widest shadow-inner">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Password Warning Card --}}
                <div class="bg-amber-50 rounded-[2rem] border border-amber-100 p-6 flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 shrink-0">
                        <i data-lucide="key-round" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-amber-800 uppercase tracking-widest mb-1">Password Management</p>
                        <p class="text-xs text-amber-700/80 leading-relaxed font-medium">
                            Untuk alasan keamanan, perubahan kata sandi dilakukan melalui modul <span class="font-bold underline">Account Security</span> atau fitur reset password.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right Side: Role & Account Status --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Account Status Toggle --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Account Status</h3>
                    <label class="relative flex items-center justify-between p-4 rounded-2xl cursor-pointer border-2 transition-all group
                        has-[:checked]:bg-emerald-500 has-[:checked]:border-emerald-500 bg-white border-slate-100">
                        
                        <input type="checkbox" name="is_active" value="1" class="hidden" 
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        
                        <div class="flex flex-col">
                            <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 group-has-[:checked]:text-emerald-100">Status</span>
                            <span class="text-sm font-black text-slate-700 uppercase group-has-[:checked]:text-white">
                                {{ old('is_active', $user->is_active) ? 'Active Account' : 'Suspended' }}
                            </span>
                        </div>
                        <div class="w-10 h-5 bg-slate-200 rounded-full relative transition-colors group-has-[:checked]:bg-white/30">
                            <div class="absolute w-4 h-4 bg-white rounded-full top-0.5 left-0.5 transition-all group-has-[:checked]:left-5.5"></div>
                        </div>
                    </label>
                </div>

                {{-- Role Selection --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Access Level</h3>
                    <div class="space-y-3">
                        @foreach($roles as $role)
                        @php $isChecked = old('role', $user->roles->first()?->name) == $role->name; @endphp
                        <label class="relative flex items-center justify-between p-4 rounded-2xl cursor-pointer border-2 transition-all duration-300 group
                            {{ $isChecked ? 'bg-indigo-600 border-indigo-600 shadow-lg shadow-indigo-100' : 'bg-white border-slate-100 hover:border-indigo-200 hover:bg-slate-50' }}">
                            
                            <input type="radio" name="role" value="{{ $role->name }}" class="hidden" {{ $isChecked ? 'checked' : '' }} required>
                            
                            <div class="flex flex-col">
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] {{ $isChecked ? 'text-indigo-100' : 'text-slate-400' }}">Assign</span>
                                <span class="text-sm font-black {{ $isChecked ? 'text-white' : 'text-slate-700' }} uppercase tracking-tighter">{{ $role->name }}</span>
                            </div>

                            <div class="w-6 h-6 rounded-full flex items-center justify-center {{ $isChecked ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-300' }}">
                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="space-y-3">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-800 shadow-xl shadow-slate-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        Update Database
                    </button>
                    <a href="{{ route('users.index') }}" class="block text-center py-2 text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-500 transition-colors">Discard & Exit</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection