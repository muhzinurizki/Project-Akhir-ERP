<header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100
               flex items-center justify-between px-8 sticky top-0 z-30">

    <div class="flex items-center gap-6">
        {{-- Mobile Menu Button --}}
        <button @click="sidebarOpen = true" 
                class="lg:hidden w-11 h-11 flex items-center justify-center rounded-2xl bg-slate-50 text-slate-600 hover:bg-slate-900 hover:text-white transition-all active:scale-95">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        {{-- Page Title & Breadcrumb --}}
        <div class="hidden sm:block">
            <h1 class="text-lg font-black text-slate-900 tracking-tighter uppercase leading-none">
                @yield('page-title', 'Dashboard')
            </h1>
            <nav class="flex items-center gap-2 mt-1.5">
                <span class="text-[10px] font-black uppercase tracking-[0.1em] text-slate-400">System</span>
                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                <span class="text-[10px] font-black uppercase tracking-[0.1em] text-indigo-600">
                    {{ request()->segment(1) ? str_replace('-', ' ', request()->segment(1)) : 'Overview' }}
                </span>
            </nav>
        </div>
    </div>

    <div x-data="{ open: false }" class="relative flex items-center gap-4">

        {{-- Global Search Bar --}}
        <div class="hidden md:flex items-center relative group">
            <i data-lucide="search" class="absolute left-4 w-4 h-4 text-slate-300 group-focus-within:text-indigo-600 transition-colors"></i>
            <input type="text" placeholder="Search anything..."
                class="pl-12 pr-6 py-2.5 bg-slate-50 border-none rounded-2xl text-xs font-bold w-48 lg:w-72 transition-all 
                       focus:ring-2 focus:ring-indigo-600/10 focus:bg-white focus:w-80 shadow-inner">
            <div class="absolute right-3 hidden lg:flex items-center gap-1 px-1.5 py-1 bg-white border border-slate-200 rounded-md shadow-sm">
                <span class="text-[9px] font-black text-slate-400">⌘</span>
                <span class="text-[9px] font-black text-slate-400">K</span>
            </div>
        </div>

        {{-- Notification --}}
        <button class="group relative w-11 h-11 rounded-2xl bg-white border border-slate-100
                       flex items-center justify-center hover:border-indigo-100 hover:bg-indigo-50/30 transition-all">
            <i data-lucide="bell" class="w-5 h-5 text-slate-400 group-hover:text-indigo-600 transition-colors"></i>
            <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
        </button>

        <div class="h-8 w-[1px] bg-slate-100 mx-1"></div>

        {{-- User Dropdown Trigger --}}
        <div class="relative">
            <button @click="open = !open" 
                    class="flex items-center gap-3 p-1.5 rounded-2xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100 group">
                <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white text-xs font-black shadow-lg shadow-slate-200 group-hover:scale-105 transition-transform">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="hidden sm:block text-left mr-2">
                    <p class="text-[11px] font-black text-slate-900 leading-none uppercase tracking-tighter">{{ auth()->user()->name }}</p>
                    <p class="text-[9px] font-bold text-indigo-600 uppercase tracking-widest mt-1">
                         {{ auth()->user()->roles->first()->name ?? 'Staff' }}
                    </p>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-300 transition-transform duration-300"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>

            {{-- Dropdown Menu --}}
            <div x-show="open" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-2 scale-95" 
                 @click.outside="open = false"
                 class="absolute right-0 top-full mt-3 w-64 bg-white border border-slate-100 rounded-[2rem] shadow-2xl shadow-slate-200/60 z-50 overflow-hidden p-2">

                <div class="px-5 py-5 bg-slate-50/50 rounded-[1.5rem] mb-2">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-1.5">Authorized Account</p>
                    <p class="text-xs font-bold text-slate-900 truncate tracking-tight">{{ auth()->user()->email }}</p>
                </div>

                <div class="space-y-1">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-3 px-4 py-3 text-[11px] font-black uppercase tracking-widest text-slate-600 rounded-[1.25rem] hover:bg-slate-50 hover:text-indigo-600 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <i data-lucide="user-cog" class="w-4 h-4"></i>
                        </div>
                        Account Settings
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 w-full px-4 py-3 text-[11px] font-black uppercase tracking-widest text-rose-500 rounded-[1.25rem] hover:bg-rose-50 transition-all group">
                            <div class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                <i data-lucide="power" class="w-4 h-4"></i>
                            </div>
                            Terminate Session
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>