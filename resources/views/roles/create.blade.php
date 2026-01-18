@extends('layouts.app')

@section('content')
<div class="p-6 max-w-[1400px] mx-auto space-y-8">
    {{-- Minimalist Header --}}
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('roles.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 hover:border-indigo-100 transition-all shadow-sm">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">New Authority Group</h1>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Definisikan role baru dan hak aksesnya</p>
            </div>
        </div>
    </div>

    <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
        @csrf
        {{-- Identity Card sama dengan Edit, hapus value default dan @method('PUT') --}}
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="max-w-md space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">New Role Name</label>
                <input type="text" name="name" placeholder="e.g. Inventory Manager" required
                    class="w-full rounded-xl border-slate-100 bg-slate-50 font-bold text-sm p-4 focus:ring-2 focus:ring-indigo-500 transition-all">
            </div>
        </div>

        {{-- Permission Grid sama dengan Edit, hilangkan in_array(checked) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            @foreach($permissions as $group => $items)
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm flex flex-col overflow-hidden">
                <div class="px-5 py-3 bg-slate-50/50 border-b border-slate-50 flex items-center gap-2">
                    <div class="w-1.5 h-1.5 rounded-full bg-indigo-500"></div>
                    <h3 class="text-[10px] font-black text-slate-500 uppercase tracking-widest">{{ $group }}</h3>
                </div>

                <div class="p-5 space-y-2">
                    @foreach($items as $permission)
                    <label class="flex items-center group cursor-pointer p-2 rounded-xl hover:bg-slate-50 transition-all">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                            class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer">
                        <div class="ml-3">
                            <span class="block text-[11px] font-bold text-slate-600 group-hover:text-indigo-600 transition-colors uppercase tracking-tight">
                                {{ str_replace(['.', '_'], ' ', Str::after($permission->name, '.')) }}
                            </span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-3 pt-4">
            <button type="submit" class="bg-indigo-600 text-white px-10 py-4 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-100 transition-all">
                Register New Role
            </button>
        </div>
    </form>
</div>
@endsection