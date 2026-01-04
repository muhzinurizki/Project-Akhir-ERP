<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-100
           transform transition-all duration-300 ease-in-out
           lg:translate-x-0 flex flex-col shadow-[4px_0_24px_rgba(0,0,0,0.04)]">

    {{-- BRAND --}}
    <div class="h-24 px-8 flex items-center shrink-0">
        <div class="flex items-center gap-4">
            <div class="relative">
                <div class="w-11 h-11 rounded-2xl bg-slate-900 flex items-center justify-center text-white font-black shadow-xl">
                    <span class="text-xl tracking-tight">E</span>
                </div>
                <span class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-emerald-500 border-[3px] border-white rounded-full"></span>
            </div>
            <div class="leading-tight">
                <h1 class="text-sm font-black text-slate-900 tracking-tight text-nowrap">ERP TEKSTIL</h1>
                <p class="text-[10px] uppercase font-bold tracking-[0.15em] text-slate-400">Enterprise System</p>
            </div>
        </div>
    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-1.5">
        @php
            $menus = [
                ['route' => 'dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],

                ['header' => 'Master Data'],
                ['route' => 'products.index', 'icon' => 'package', 'label' => 'Products'],
                ['route' => 'warehouses.index', 'icon' => 'warehouse', 'label' => 'Warehouses'],
                ['route' => 'suppliers.index', 'icon' => 'truck', 'label' => 'Suppliers'],

                ['header' => 'Inventory'],
                ['route' => 'inventory.index', 'icon' => 'boxes', 'label' => 'Stock Balances'],
                ['route' => 'inventory.movements', 'icon' => 'history', 'label' => 'Stock Movements'],
                ['route' => 'goods-receipts.index', 'icon' => 'package-check', 'label' => 'Goods Receipt'],

                ['header' => 'Procurement'],
                ['route' => 'purchase-requests.index', 'icon' => 'shopping-cart', 'label' => 'Purchase Request'],
                ['route' => 'purchase-orders.index', 'icon' => 'shopping-bag', 'label' => 'Purchase Order'],

                ['header' => 'Finance'],
                ['route' => 'accounts-payables.index', 'icon' => 'credit-card', 'label' => 'Accounts Payable'],
                ['route' => 'ap-payments.index', 'icon' => 'banknote', 'label' => 'Payments'],

                ['header' => 'Administration'],
                ['route' => 'users.index', 'icon' => 'users', 'label' => 'User Management'],
                ['route' => 'roles.index', 'icon' => 'shield-check', 'label' => 'Role Management'],
            ];
        @endphp

        @foreach ($menus as $menu)
            @if (isset($menu['header']))
                <div class="pt-5 pb-2 px-4">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ $menu['header'] }}</p>
                </div>
            @else
                @php
                    // Logika Active yang diperbaiki:
                    // Jika route adalah inventory.index, hanya aktif jika persis inventory.index atau sub-routenya (create-in/out)
                    // Jika route adalah inventory.movements, hanya aktif jika persis inventory.movements
                    $isActive = request()->routeIs($menu['route']);

                    // Tambahan khusus untuk Inventory Stock Balances agar tetap aktif saat create-in/out
                    if ($menu['route'] === 'inventory.index' && (request()->routeIs('inventory.create-in') || request()->routeIs('inventory.create-out'))) {
                        $isActive = true;
                    }
                @endphp

                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                   class="group flex items-center justify-between px-3 py-2 rounded-xl transition-all duration-200
                          {{ $isActive
                                ? 'bg-slate-900 text-white shadow-md'
                                : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-colors
                                    {{ $isActive ? 'bg-white/10' : 'bg-slate-50 group-hover:bg-white border border-transparent group-hover:border-slate-100' }}">
                            <i data-lucide="{{ $menu['icon'] }}"
                               class="w-4 h-4 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-900' }}"></i>
                        </div>
                        <span class="text-xs font-bold tracking-tight">{{ $menu['label'] }}</span>
                    </div>

                    @if ($isActive)
                        <span class="w-1 h-1 rounded-full bg-emerald-400 shadow-[0_0_8px_rgba(52,211,153,0.8)] mr-1"></span>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>

    {{-- USER PANEL --}}
    <div class="p-4 mt-auto border-t border-slate-50">
        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100">
            <div class="flex items-center gap-3">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0f172a&color=fff"
                    class="w-9 h-9 rounded-xl shadow-sm"
                    alt="User">

                <div class="flex-1 min-w-0">
                    <p class="text-[11px] font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider truncate">
                        {{ auth()->user()->roles->first()->name ?? 'Staff' }}
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                    @csrf
                    <button type="submit"
                        class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center
                               hover:bg-rose-50 hover:border-rose-100 hover:text-rose-600 transition-all group">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>