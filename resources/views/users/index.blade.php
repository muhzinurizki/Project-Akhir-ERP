@extends('layouts.app')

@section('title', 'User Management')
@section('page-title', 'User Management')

@section('content')
<div class="space-y-6">

  {{-- Header Section --}}
  <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Pengguna</h2>
      <p class="text-sm text-slate-500 font-medium">Kelola akses, role, dan identitas staf dalam sistem.</p>
    </div>

    <div class="flex items-center gap-3">
      <div class="relative group">
        <i data-lucide="search"
          class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
        <input type="text" placeholder="Cari user..."
          class="pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all w-full md:w-64">
      </div>
      <a href="{{ route('users.create') }}"
        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 active:scale-95">
        <i data-lucide="user-plus" class="w-4.5 h-4.5"></i>
        Tambah User
      </a>
    </div>
  </div>

  {{-- Content Card --}}
  <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left border-separate border-spacing-0">
        <thead class="bg-slate-50/50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
          <tr>
            <th class="px-8 py-5">Identitas User</th>
            <th class="px-6 py-5">Role / Akses</th>
            <th class="px-6 py-5">Status Email</th>
            <th class="px-6 py-5">Terdaftar Pada</th>
            <th class="px-8 py-5 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          @forelse($users as $user)
          <tr class="hover:bg-slate-50/50 transition-all group">
            <td class="px-8 py-5">
              <div class="flex items-center gap-4">
                <div
                  class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center border-2 border-white shadow-sm overflow-hidden">
                  {{-- Placeholder Avatar jika tidak ada foto --}}
                  <span class="text-xs font-black text-slate-500">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                </div>
                <div class="flex flex-col">
                  <span class="font-bold text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">{{
                    $user->name }}</span>
                  <span class="text-[11px] text-slate-400 font-medium">{{ $user->email }}</span>
                </div>
              </div>
            </td>
            <td class="px-6 py-4">
              <div class="flex flex-wrap gap-1.5">
                @forelse($user->roles as $role)
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-black tracking-wider uppercase bg-indigo-50 text-indigo-600 border border-indigo-100">
                  {{ $role->name }}
                </span>
                @empty
                <span class="text-[10px] font-bold text-slate-300 italic">No Role Assigned</span>
                @endforelse
              </div>
            </td>
            <td class="px-6 py-4">
              @if($user->email_verified_at)
              <span class="inline-flex items-center gap-1 text-emerald-600 font-bold text-[11px]">
                <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Verified
              </span>
              @else
              <span class="inline-flex items-center gap-1 text-amber-500 font-bold text-[11px]">
                <i data-lucide="help-circle" class="w-3.5 h-3.5"></i> Pending
              </span>
              @endif
            </td>
            <td class="px-6 py-4 text-slate-500 font-medium text-xs">
              {{ $user->created_at?->format('d M Y') ?? '-' }}
            </td>
            <td class="px-8 py-4 text-right">
              <div class="flex justify-end gap-2">
                <a href="{{ route('users.edit', $user) }}"
                  class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 transition-all shadow-sm border border-slate-100">
                  <i data-lucide="pencil" class="w-4 h-4"></i>
                </a>
                {{-- Gunakan modal untuk delete di masa depan --}}
                <button
                  class="p-2 rounded-lg bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 transition-all shadow-sm border border-slate-100">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="px-8 py-20 text-center">
              <div class="flex flex-col items-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                  <i data-lucide="users" class="w-8 h-8 text-slate-200"></i>
                </div>
                <p class="text-slate-500 font-bold">Belum ada pengguna terdaftar</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Pagination Custom --}}
  @if($users->hasPages())
  <div class="mt-6 px-4">
    {{ $users->links() }}
  </div>
  @endif

</div>
@endsection