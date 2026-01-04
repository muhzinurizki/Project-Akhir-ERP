@extends('layouts.app')

@section('title', 'Edit User | ERP Tekstil')

@section('content')
<div class="max-w-4xl mx-auto p-8 pb-20">
    
    {{-- Navigation Header --}}
    <div class="mb-10 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('users.index') }}" 
               class="p-3 rounded-2xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm group">
                <i data-lucide="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tighter uppercase leading-none">Modify Profile</h1>
                <p class="text-slate-500 text-sm font-medium mt-1">ID Pengguna: <span class="font-mono text-indigo-600 font-bold">#{{ $user->id }}</span></p>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-amber-50 rounded-xl border border-amber-100">
            <i data-lucide="shield-alert" class="w-4 h-4 text-amber-500"></i>
            <span class="text-[10px] font-black text-amber-700 uppercase tracking-widest">Admin Authorization</span>
        </div>
    </div>

    {{-- Form Container --}}
    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- Left Side: Main Info --}}
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-1.5 h-6 bg-slate-900 rounded-full"></div>
                        <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest">Personal Credentials</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Full Name</label>
                            <div class="relative group">
                                <i data-lucide="user" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('name') <p class="text-rose-500 text-[10px] font-bold uppercase mt-2 ml-1 tracking-tight">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Email Address</label>
                            <div class="relative group">
                                <i data-lucide="mail" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-500 transition-colors"></i>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-600 focus:bg-white transition-all text-sm font-bold text-slate-700 shadow-inner">
                            </div>
                            @error('email') <p class="text-rose-500 text-[10px] font-bold uppercase mt-2 ml-1 tracking-tight">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-12 p-6 bg-indigo-50/50 rounded-[2rem] border border-indigo-100/50">
                        <div class="flex gap-4">
                            <div class="p-2 bg-indigo-100 rounded-lg h-fit text-indigo-600">
                                <i data-lucide="info" class="w-4 h-4"></i>
                            </div>
                            <p class="text-xs text-indigo-700 leading-relaxed font-medium">
                                <span class="font-black uppercase tracking-tighter block mb-1">Keamanan Password:</span>
                                Untuk merubah password, silakan gunakan fitur <span class="font-black underline">Reset Password</span> pada halaman manajemen akun atau biarkan kosong jika tidak ada perubahan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Side: Role & Status --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
                    <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-6">Access Level</h3>
                    
                    <div class="space-y-3">
                        @foreach($roles as $role)
                        @php $isChecked = old('role', $user->roles->first()?->name) == $role->name; @endphp
                        <label class="relative flex items-center justify-between p-4 rounded-2xl cursor-pointer border-2 transition-all duration-300 group
                            {{ $isChecked ? 'bg-indigo-600 border-indigo-600 shadow-lg shadow-indigo-100' : 'bg-white border-slate-100 hover:border-indigo-200 hover:bg-slate-50' }}">
                            
                            <input type="radio" name="role" value="{{ $role->name }}" class="hidden" {{ $isChecked ? 'checked' : '' }} required>
                            
                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] {{ $isChecked ? 'text-indigo-100' : 'text-slate-400' }}">Role</span>
                                <span class="text-sm font-black {{ $isChecked ? 'text-white' : 'text-slate-700' }} uppercase tracking-tighter">{{ $role->name }}</span>
                            </div>

                            <div class="w-6 h-6 rounded-full flex items-center justify-center {{ $isChecked ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-300 group-hover:bg-indigo-50 group-hover:text-indigo-400' }}">
                                <i data-lucide="{{ $isChecked ? 'check-circle-2' : 'circle' }}" class="w-4 h-4"></i>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('role') <p class="text-rose-500 text-[10px] font-bold uppercase mt-4 text-center">{{ $message }}</p> @enderror
                </div>

                {{-- Submit Actions --}}
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full py-5 bg-slate-900 text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-slate-800 shadow-2xl shadow-slate-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                        <i data-lucide="save" class="w-4 h-4 text-emerald-400"></i>
                        Save Changes
                    </button>
                    <a href="{{ route('users.index') }}" class="w-full py-4 text-center text-slate-400 font-bold text-[10px] uppercase tracking-widest hover:text-slate-600 transition-colors">
                        Discard Changes
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection