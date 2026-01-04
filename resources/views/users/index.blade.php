@extends('layouts.app')

@section('title', 'User Management | ERP Tekstil')

@section('content')
<div class="max-w-7xl mx-auto p-8 pb-20">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
        <div class="flex items-center gap-5">
            <div class="p-4 bg-indigo-600 rounded-[1.5rem] shadow-xl shadow-indigo-100">
                <i data-lucide="shield-check" class="w-8 h-8 text-white"></i>
            </div>
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase leading-none mb-2">Access Control</h1>
                <p class="text-slate-400 font-medium">Kelola hak akses, role, dan kredensial staf sistem.</p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:flex-none group">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                <input type="text" placeholder="Cari nama atau email..." 
                    class="w-full md:w-72 pl-12 pr-6 py-4 bg-white border-none rounded-2xl text-sm font-bold shadow-sm ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-600 transition-all">
            </div>
            <a href="{{ route('users.create') }}" class="flex items-center gap-2 px-6 py-4 bg-slate-900 text-white rounded-2xl font-black hover:bg-slate-800 transition-all shadow-xl active:scale-95 text-xs uppercase tracking-widest">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                Add User
            </a>
        </div>
    </div>

    {{-- Quick Overview Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Personnel</p>
                <h3 class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $users->total() }}</h3>
            </div>
        </div>
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                <i data-lucide="verified" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Verified Access</p>
                <h3 class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $users->whereNotNull('email_verified_at')->count() }}</h3>
            </div>
        </div>
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                <i data-lucide="key" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Active Roles</p>
                <h3 class="text-2xl font-black text-slate-900 leading-none mt-1">4 Type Access</h3>
            </div>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-[3rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-10 py-6 text-center w-24">Identity</th>
                        <th class="px-6 py-6">User Detail</th>
                        <th class="px-6 py-6">Privileges</th>
                        <th class="px-6 py-6">Status</th>
                        <th class="px-10 py-6 text-right">Settings</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm font-medium">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/30 transition-all group">
                        <td class="px-10 py-6">
                            <div class="relative inline-block">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-indigo-100 border-2 border-white group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                @if($user->email_verified_at)
                                <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full flex items-center justify-center shadow-sm">
                                    <i data-lucide="check" class="w-3 h-3 text-white font-black"></i>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-900 text-base tracking-tight uppercase group-hover:text-indigo-600 transition-colors">{{ $user->name }}</span>
                                <span class="text-[11px] text-slate-400 font-bold mt-0.5 tracking-tight italic">{{ $user->email }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-wrap gap-2">
                                @forelse($user->roles as $role)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-100">
                                    {{ $role->name }}
                                </span>
                                @empty
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">No Privileges</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1.5">Joined On</p>
                                <span class="text-xs font-bold text-slate-600 uppercase">{{ $user->created_at?->format('d M Y') ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="p-3 bg-white border border-slate-100 text-slate-400 rounded-xl hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all shadow-sm active:scale-95">
                                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                                </a>
                                <button class="p-3 bg-white border border-slate-100 text-slate-300 rounded-xl hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm active:scale-95">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-32 text-center">
                            <div class="flex flex-col items-center">
                                <div class="p-6 bg-slate-50 rounded-full mb-4 text-slate-200">
                                    <i data-lucide="user-x" class="w-16 h-16"></i>
                                </div>
                                <h3 class="text-slate-900 font-black uppercase">Database Empty</h3>
                                <p class="text-slate-400 text-sm mt-1 font-medium">No users found in the system registry.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="p-8 bg-slate-50/50 border-t border-slate-100">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection