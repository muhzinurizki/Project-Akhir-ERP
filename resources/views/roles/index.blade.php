@extends('layouts.app')

@section('content')
<div class="p-6 max-w-[1600px] mx-auto space-y-6">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
        <div>
            <h1 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter">Authority Matrix</h1>
            <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-1">Management Role & Hak Akses Sistem</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('roles.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-3 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg shadow-indigo-100">
                <i data-lucide="plus-circle" class="w-4 h-4 text-indigo-200"></i>
                Create New Role
            </a>
        </div>
    </div>

    {{-- Minimalist Table Section --}}
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Role Name</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">User Count</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Permissions</th>
                        <th class="px-6 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($roles as $role)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black italic text-sm shadow-lg shadow-slate-200">
                                    {{ substr($role->name, 0, 1) }}
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-slate-800 uppercase tracking-tight">{{ $role->name }}</span>
                                    <span class="text-[10px] text-slate-400 font-medium tracking-wide italic leading-none">Guard: {{ $role->guard_name }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-2">
                                <i data-lucide="users" class="w-4 h-4 text-slate-300"></i>
                                <span class="text-sm font-bold text-slate-600">{{ $role->users_count }}</span>
                                <span class="text-[10px] font-bold text-slate-300 uppercase italic">Personnel</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 h-1.5 w-24 bg-slate-100 rounded-full overflow-hidden">
                                    @php 
                                        $totalPerms = \Spatie\Permission\Models\Permission::count();
                                        $percent = $totalPerms > 0 ? ($role->permissions_count / $totalPerms) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $percent }}%"></div>
                                </div>
                                <span class="text-xs font-black text-indigo-600 italic">{{ $role->permissions_count }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($role->name === 'Admin')
                                <span class="text-[9px] font-black bg-indigo-50 text-indigo-600 px-2.5 py-1 rounded-lg uppercase tracking-widest border border-indigo-100">Full Access</span>
                            @else
                                <span class="text-[9px] font-black bg-slate-100 text-slate-500 px-2.5 py-1 rounded-lg uppercase tracking-widest">Restricted</span>
                            @endif
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('roles.edit', $role->id) }}" class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 transition-all shadow-sm">
                                    <i data-lucide="settings-2" class="w-4 h-4"></i>
                                </a>
                                @if($role->name !== 'Admin')
                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Hapus role ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-rose-600 hover:border-rose-200 hover:bg-rose-50 transition-all shadow-sm">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection