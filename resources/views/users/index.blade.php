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
            <form action="{{ route('users.index') }}" method="GET" class="relative flex-1 md:flex-none group">
                <i data-lucide="search" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau NIK..." 
                    class="w-full md:w-72 pl-12 pr-6 py-4 bg-white border-none rounded-2xl text-sm font-bold shadow-sm ring-1 ring-slate-100 focus:ring-2 focus:ring-indigo-600 transition-all">
            </form>
            <a href="{{ route('users.create') }}" class="flex items-center gap-2 px-6 py-4 bg-slate-900 text-white rounded-2xl font-black hover:bg-slate-800 transition-all shadow-xl active:scale-95 text-xs uppercase tracking-widest text-center">
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
                <i data-lucide="user-check" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Active Status</p>
                <h3 class="text-2xl font-black text-slate-900 leading-none mt-1">{{ $users->where('is_active', true)->count() }}</h3>
            </div>
        </div>
        <div class="bg-white p-7 rounded-[2.5rem] border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                <i data-lucide="key" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Your Identity</p>
                <h3 class="text-2xl font-black text-slate-900 leading-none mt-1">{{ auth()->user()->employee_code }}</h3>
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
                        <th class="px-6 py-6">Karyawan</th>
                        <th class="px-6 py-6">Akses & Privileges</th>
                        <th class="px-6 py-6">Status Akun</th>
                        <th class="px-10 py-6 text-right">Settings</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm font-medium">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50/30 transition-all group">
                        <td class="px-10 py-6 text-center">
                            <div class="relative inline-block">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center text-white font-black text-sm shadow-lg shadow-slate-100 border-2 border-white group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col">
                                <span class="font-black text-slate-900 text-base tracking-tight uppercase group-hover:text-indigo-600 transition-colors">{{ $user->name }}</span>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[10px] bg-slate-100 px-2 py-0.5 rounded text-slate-500 font-black tracking-widest">{{ $user->employee_code }}</span>
                                    <span class="text-[11px] text-slate-400 font-bold italic">{{ $user->email }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-wrap gap-2">
                                @forelse($user->roles as $role)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-[9px] font-black uppercase tracking-widest border border-indigo-100">
                                    {{ $role->name }}
                                </span>
                                @empty
                                <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">General User</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @if($user->is_active)
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full bg-rose-50 text-rose-600 text-[10px] font-black uppercase tracking-wider">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span> Non-Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <a href="{{ route('users.edit', $user) }}" 
                                   class="p-3 bg-white border border-slate-100 text-slate-400 rounded-xl hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all shadow-sm active:scale-95 tooltip" title="Edit User">
                                    <i data-lucide="edit-3" class="w-4 h-4"></i>
                                </a>
                                
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete p-3 bg-white border border-slate-100 text-slate-300 rounded-xl hover:bg-rose-500 hover:text-white hover:border-rose-500 transition-all shadow-sm active:scale-95 tooltip" title="Delete User">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                @endif
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
                                <h3 class="text-slate-900 font-black uppercase">No Users Found</h3>
                                <p class="text-slate-400 text-sm mt-1 font-medium">Coba gunakan kata kunci pencarian lain.</p>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Hapus Karyawan?',
                text: "Aksi ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1e293b',
                cancelButtonColor: '#f43f5e',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                borderRadius: '1.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    });
</script>
@endpush