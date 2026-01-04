@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User: ' . $user->name)

@section('content')
<div class="max-w-3xl space-y-6">
  {{-- Header --}}
  <div class="flex items-center gap-4">
    <a href="{{ route('users.index') }}"
      class="p-2 rounded-xl bg-white border border-slate-100 text-slate-400 hover:text-indigo-600 transition-all shadow-sm">
      <i data-lucide="arrow-left" class="w-5 h-5"></i>
    </a>
    <div>
      <h2 class="text-2xl font-black text-slate-900 tracking-tight">Edit Pengguna</h2>
      <p class="text-sm text-slate-500 font-medium">Perbarui informasi profil dan hak akses akun.</p>
    </div>
  </div>

  {{-- Alert Info (Opsi) --}}
  <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 flex gap-3">
    <i data-lucide="info" class="w-5 h-5 text-indigo-600"></i>
    <p class="text-xs text-indigo-700 leading-relaxed font-medium">
      Mengubah email akan mengharuskan pengguna untuk melakukan verifikasi ulang jika sistem verifikasi email aktif.
      Password tidak ditampilkan di sini demi keamanan.
    </p>
  </div>

  {{-- Form Card --}}
  <form method="POST" action="{{ route('users.update', $user) }}"
    class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
    @csrf
    @method('PUT')

    <div class="p-8 md:p-10 space-y-8">
      {{-- Grid Section: Profil --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
          <div class="relative">
            <i data-lucide="user" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
              class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all text-sm font-bold text-slate-700"
              required>
          </div>
          @error('name') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
        </div>

        <div>
          <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Email</label>
          <div class="relative">
            <i data-lucide="mail" class="w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
              class="w-full pl-11 pr-4 py-3 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500/20 focus:bg-white transition-all text-sm font-bold text-slate-700"
              required>
          </div>
          @error('email') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
        </div>
      </div>

      <hr class="border-slate-50">

      {{-- Role Selection --}}
      <div>
        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-3">Role / Hak Akses</label>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          @foreach($roles as $role)
          @php $isChecked = old('role', $user->roles->first()?->name) == $role->name; @endphp
          <label
            class="relative flex items-center gap-3 p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all has-[:checked]:bg-indigo-50 has-[:checked]:ring-2 has-[:checked]:ring-indigo-500/20 group">
            <input type="radio" name="role" value="{{ $role->name }}"
              class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500" {{ $isChecked ? 'checked' : '' }}
              required>
            <div class="flex flex-col">
              <span
                class="text-sm font-black text-slate-700 group-has-[:checked]:text-indigo-700 uppercase tracking-tight">{{
                $role->name }}</span>
              <span class="text-[10px] text-slate-400 font-medium leading-tight italic">Level: {{ $loop->iteration
                }}</span>
            </div>
          </label>
          @endforeach
        </div>
        @error('role') <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p> @enderror
      </div>
    </div>

    {{-- Footer Action --}}
    <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-50 flex items-center justify-between">
      <div class="flex items-center gap-2 text-slate-400">
        <i data-lucide="clock" class="w-4 h-4"></i>
        <span class="text-[10px] font-bold uppercase tracking-wider">Update Terakhir: {{
          $user->updated_at->diffForHumans() }}</span>
      </div>
      <div class="flex gap-3">
        <a href="{{ route('users.index') }}"
          class="px-6 py-3 rounded-2xl text-slate-500 font-bold text-sm hover:bg-slate-100 transition-all">
          Batal
        </a>
        <button type="submit"
          class="px-8 py-3 rounded-2xl bg-slate-900 text-white font-black text-sm hover:bg-slate-800 shadow-lg shadow-slate-100 transition-all active:scale-95 flex items-center gap-2">
          <i data-lucide="refresh-cw" class="w-4 h-4"></i>
          Perbarui User
        </button>
      </div>
    </div>
  </form>
</div>
@endsection