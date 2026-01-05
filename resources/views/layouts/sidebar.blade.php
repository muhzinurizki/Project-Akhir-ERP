<aside x-data="{}" :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-100 
           transform transition-all duration-300 ease-in-out
           lg:translate-x-0 flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.02)]">

    {{-- BRAND SECTION --}}
    <div class="h-24 px-8 flex items-center shrink-0">
        <div class="flex items-center gap-4">
            <div class="relative group cursor-pointer">
                <div
                    class="w-12 h-12 rounded-[1.25rem] bg-slate-900 flex items-center justify-center text-white font-black shadow-lg group-hover:rotate-6 transition-transform duration-300">
                    <span class="text-xl tracking-tighter">E</span>
                </div>
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 border-[3px] border-white rounded-full">
                </div>
            </div>
            <div class="leading-none">
                <h1 class="text-[13px] font-black text-slate-900 tracking-tighter uppercase">ERP Tekstil</h1>
                <p class="text-[9px] uppercase font-black tracking-[0.2em] text-slate-300 mt-1">Core Engine</p>
            </div>
        </div>
    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1 custom-scrollbar">
        @php
            $menus = [
                ['route' => 'dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],

                ['header' => 'Master Data'],
                ['route' => 'products.index', 'icon' => 'package', 'label' => 'Products'],
                ['route' => 'warehouses.index', 'icon' => 'warehouse', 'label' => 'Warehouses'],
                ['route' => 'suppliers.index', 'icon' => 'truck', 'label' => 'Suppliers'],

                ['header' => 'Inventory Management'],
                ['route' => 'inventory.index', 'icon' => 'boxes', 'label' => 'Stock Balances'],
                ['route' => 'inventory.movements', 'icon' => 'history', 'label' => 'Stock Movements'],
                ['route' => 'goods-receipts.index', 'icon' => 'package-check', 'label' => 'Goods Receipt'],

                ['header' => 'Procurement'],
                ['route' => 'purchase-requests.index', 'icon' => 'shopping-cart', 'label' => 'Purchase Request'],
                ['route' => 'purchase-orders.index', 'icon' => 'shopping-bag', 'label' => 'Purchase Order'],

                ['header' => 'Finance & Admin'],
                ['route' => 'purchase-invoices.index', 'icon' => 'wallet', 'label' => 'Account Payable'],

                ['header' => 'User Management'],
                ['route' => 'users.index', 'icon' => 'users', 'label' => 'User Management'],
                ['route' => 'roles.index', 'icon' => 'shield-check', 'label' => 'Role Management'],
            ];
        @endphp

        @foreach ($menus as $menu)
            @if (isset($menu['header']))
                <div class="pt-6 pb-2 px-4">
                    <p class="text-[10px] font-black text-slate-300 uppercase tracking-[0.25em]">{{ $menu['header'] }}
                    </p>
                </div>
            @else
                @php
                    // Logika Active State: Mencocokkan route utama dan sub-route (wildcard)
                    $isActive = request()->routeIs($menu['route'] . '*');

                    // Override khusus untuk Inventory Stock Balances agar tetap aktif saat di sub-page in/out
                    if (
                        $menu['route'] === 'inventory.index' &&
                        (request()->routeIs('inventory.create-in') || request()->routeIs('inventory.create-out'))
                    ) {
                        $isActive = true;
                    }
                @endphp

                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                    class="group flex items-center justify-between px-3 py-2.5 rounded-2xl transition-all duration-300
                          {{ $isActive
                              ? 'bg-slate-900 text-white shadow-xl shadow-slate-200'
                              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300
                                    {{ $isActive ? 'bg-white/10' : 'bg-slate-50 group-hover:bg-white border border-transparent group-hover:border-slate-100 shadow-sm' }}">
                            <i data-lucide="{{ $menu['icon'] }}"
                                class="w-4 h-4 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-900' }}"></i>
                        </div>
                        <span class="text-[12px] font-bold tracking-tight">{{ $menu['label'] }}</span>
                    </div>

                    @if ($isActive)
                        <div class="w-1.5 h-5 bg-emerald-400 rounded-full shadow-[0_0_12px_rgba(52,211,153,0.6)] mr-1">
                        </div>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>

    {{-- USER PANEL --}}
    <div class="p-6 mt-auto">
        <div class="p-4 rounded-[2rem] bg-slate-900 border border-slate-800 shadow-2xl">
            <div class="flex items-center gap-3">
                <div class="relative">
                    {{-- UI Avatars: Generate avatar berdasarkan nama user --}}
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=6366f1&color=fff"
                        class="w-10 h-10 rounded-2xl border-2 border-slate-800 shadow-lg" alt="User">
                    <span
                        class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-slate-900 rounded-full shadow-sm"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-black text-white truncate uppercase tracking-tighter">
                        {{ auth()->user()->name }}</p>
                    <p class="text-[9px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                        {{ auth()->user()->roles->first()->name ?? 'Staff' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2 mt-4">
                {{-- Tombol Pengaturan --}}
                <a href="#"
                    class="flex items-center justify-center py-2 bg-slate-800 rounded-xl text-slate-400 hover:text-white hover:bg-slate-700 transition-all group/settings">
                    <i data-lucide="settings"
                        class="w-3.5 h-3.5 group-hover/settings:rotate-45 transition-transform duration-500"></i>
                </a>

                {{-- Tombol Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center py-2 bg-rose-500/10 rounded-xl text-rose-500 hover:bg-rose-500 hover:text-white transition-all group/logout">
                        <i data-lucide="log-out"
                            class="w-3.5 h-3.5 group-hover/logout:translate-x-0.5 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
