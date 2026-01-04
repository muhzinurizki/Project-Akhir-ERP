<header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-100
               flex items-center justify-between px-8 sticky top-0 z-30">

  <div class="flex items-center gap-6">
    {{-- Mobile Menu Button --}}
    <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 flex items-center justify-center
                       rounded-xl bg-slate-50 text-slate-600 hover:bg-slate-100 transition-colors">
      <i data-lucide="menu" class="w-5 h-5"></i>
    </button>

    {{-- Page Title & Breadcrumb (Optional but recommended) --}}
    <div>
      <h1 class="text-xl font-bold text-slate-900 tracking-tight">
        @yield('page-title', 'Dashboard')
      </h1>
      <div class="flex items-center gap-2 mt-0.5">
        <span class="text-[11px] font-medium text-slate-400">Overview</span>
        <div class="w-1 h-1 rounded-full bg-slate-300"></div>
        <span class="text-[11px] font-medium text-slate-400 capitalize">{{ request()->segment(1) ?? 'Main' }}</span>
      </div>
    </div>
  </div>

  <div x-data="{ open: false }" class="relative flex items-center gap-3">

    {{-- Global Search (New for Premium Feel) --}}
    <div class="hidden md:flex items-center relative mr-2">
      <i data-lucide="search" class="absolute left-3 w-4 h-4 text-slate-400"></i>
      <input type="text" placeholder="Search data..."
        class="pl-10 pr-4 py-2 bg-slate-50 border-transparent focus:border-slate-200 focus:bg-white focus:ring-0 rounded-xl text-sm w-48 lg:w-64 transition-all">
    </div>

    {{-- Notification --}}
    <button class="group relative w-10 h-10 rounded-xl bg-white border border-slate-100
                       flex items-center justify-center hover:bg-slate-50 transition-all shadow-sm">
      <i data-lucide="bell" class="w-5 h-5 text-slate-500 group-hover:text-slate-900 transition-colors"></i>
      <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
    </button>

    <div class="h-6 w-[1px] bg-slate-200 mx-1"></div>

    {{-- User Dropdown Trigger --}}
    <button @click="open = !open" class="flex items-center gap-3 p-1 rounded-xl hover:bg-slate-50 transition-all">
      <div class="w-9 h-9 rounded-lg bg-slate-900 flex items-center justify-center
                        text-white text-xs font-bold shadow-md shadow-slate-200">
        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
      </div>
      <div class="hidden sm:block text-left">
        <p class="text-xs font-bold text-slate-900 leading-none mb-1">{{ auth()->user()->name }}</p>
        <p class="text-[10px] font-medium text-slate-500 leading-none">Super Admin</p>
      </div>
      <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 transition-transform duration-200"
        :class="open ? 'rotate-180' : ''"></i>
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-100"
      x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
      x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
      x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false"
      class="absolute right-0 top-14 w-60 bg-white border border-slate-100 rounded-2xl shadow-xl shadow-slate-200/50 z-50 overflow-hidden">

      <div class="px-5 py-4 bg-slate-50/50 border-b border-slate-100">
        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1">Account Info</p>
        <p class="text-sm font-bold text-slate-900 truncate">{{ auth()->user()->email }}</p>
      </div>

      <div class="p-2">
        <a href="{{ route('profile.edit') }}"
          class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors group">
          <i data-lucide="user" class="w-4 h-4 text-slate-400 group-hover:text-slate-900"></i>
          My Profile
        </a>
        <a href="#"
          class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-slate-600 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-colors group">
          <i data-lucide="settings" class="w-4 h-4 text-slate-400 group-hover:text-slate-900"></i>
          Settings
        </a>
      </div>

      <div class="p-2 border-t border-slate-50">
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button
            class="flex items-center gap-3 w-full px-3 py-2.5 text-sm font-semibold text-rose-600 rounded-xl hover:bg-rose-50 transition-colors group">
            <i data-lucide="log-out" class="w-4 h-4 text-rose-500 group-hover:translate-x-1 transition-transform"></i>
            Sign out
          </button>
        </form>
      </div>
    </div>
  </div>
</header>