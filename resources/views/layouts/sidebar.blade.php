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
                    <span class="text-xl tracking-tighter italic">E</span>
                </div>
                <div class="absolute -top-1 -right-1 w-4 h-4 bg-indigo-500 border-[3px] border-white rounded-full"></div>
            </div>
            <div class="leading-none">
                <h1 class="text-[13px] font-black text-slate-900 tracking-tighter uppercase italic">ERP <span
                        class="text-indigo-600">Tekstil</span></h1>
                <p class="text-[9px] uppercase font-black tracking-[0.2em] text-slate-300 mt-1 italic">Core Engine</p>
            </div>
        </div>
    </div>

    {{-- NAVIGATION --}}
    <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1 custom-scrollbar">
        @php
            $sidebarMenus = [
                ['route' => 'dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],

                ['header' => 'Master Data'],
                ['route' => 'products.index', 'icon' => 'package', 'label' => 'Products'],
                ['route' => 'warehouses.index', 'icon' => 'warehouse', 'label' => 'Warehouses'],
                ['route' => 'suppliers.index', 'icon' => 'truck', 'label' => 'Suppliers'],
                ['route' => 'customers.index', 'icon' => 'users-round', 'label' => 'Customers'],

                ['header' => 'Inventory'],
                ['route' => 'inventory.index', 'icon' => 'boxes', 'label' => 'Stock Balances'],
                ['route' => 'inventory.movements', 'icon' => 'history', 'label' => 'Stock Movements'],
                ['route' => 'goods-receipts.index', 'icon' => 'package-check', 'label' => 'Goods Receipt'],

                ['header' => 'Procurement'],
                ['route' => 'purchase-requests.index', 'icon' => 'shopping-cart', 'label' => 'Purchase Request'],
                ['route' => 'purchase-orders.index', 'icon' => 'shopping-bag', 'label' => 'Purchase Order'],

                ['header' => 'Sales & Distribution'],
                ['route' => 'sales-orders.index', 'icon' => 'file-spreadsheet', 'label' => 'Sales Order'],
                ['route' => 'delivery-orders.index', 'icon' => 'truck', 'label' => 'Delivery Order'],

                ['header' => 'Finance & Admin'],
                ['route' => 'purchase-invoices.index', 'icon' => 'wallet', 'label' => 'Account Payable'],
                ['route' => 'sales-invoices.index', 'icon' => 'badge-dollar-sign', 'label' => 'Account Receivable'],

                ['header' => 'User Management'],
                ['route' => 'users.index', 'icon' => 'users', 'label' => 'User Management'],
                ['route' => 'roles.index', 'icon' => 'shield-check', 'label' => 'Permissions']
            ];
        @endphp

        @foreach ($sidebarMenus as $menu)
            @if (isset($menu['header']))
                <div class="pt-6 pb-2 px-4">
                    <p
                        class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic leading-none border-l-2 border-slate-100 pl-3">
                        {{ $menu['header'] }}
                    </p>
                </div>
            @else
                @php
                    $isActive = request()->routeIs($menu['route'] . '*');

                    // Logic khusus untuk Inventory
                    if (
                        $menu['route'] === 'inventory.index' &&
                        (request()->routeIs('inventory.create-in') || request()->routeIs('inventory.create-out'))
                    ) {
                        $isActive = true;
                    }
                @endphp

                <a href="{{ Route::has($menu['route']) ? route($menu['route']) : '#' }}"
                    class="group flex items-center justify-between px-3 py-2.5 rounded-[1.25rem] transition-all duration-300
                          {{ $isActive
                              ? 'bg-slate-900 text-white shadow-xl shadow-slate-200'
                              : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' }}">

                    <div class="flex items-center gap-3">
                        <div
                            class="w-9 h-9 rounded-xl flex items-center justify-center transition-all duration-300
                                    {{ $isActive ? 'bg-indigo-500/20' : 'bg-slate-50 group-hover:bg-white border border-transparent group-hover:border-slate-100 shadow-sm' }}">
                            <i data-lucide="{{ $menu['icon'] }}"
                                class="w-4 h-4 {{ $isActive ? 'text-indigo-400' : 'text-slate-400 group-hover:text-slate-900' }}"></i>
                        </div>
                        <span
                            class="text-[11px] font-black uppercase tracking-tight italic {{ $isActive ? 'text-white' : 'text-slate-600' }}">
                            {{ $menu['label'] }}
                        </span>
                    </div>

                    @if ($isActive)
                        <div
                            class="w-1.5 h-1.5 bg-indigo-400 rounded-full shadow-[0_0_12px_rgba(99,102,241,0.8)] mr-2 animate-pulse">
                        </div>
                    @endif
                </a>
            @endif
        @endforeach
    </nav>

    {{-- USER PANEL --}}
    <div class="p-4 mt-auto">
        <div class="p-4 rounded-[2.5rem] bg-slate-50 border border-slate-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="relative shrink-0">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0f172a&color=fff&bold=true"
                        class="w-10 h-10 rounded-2xl border-2 border-white shadow-md" alt="User">
                    <span
                        class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-[3px] border-slate-50 rounded-full"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <p
                        class="text-[11px] font-black text-slate-900 truncate uppercase italic tracking-tighter leading-none">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[9px] text-indigo-500 font-black uppercase tracking-[0.15em] mt-1 italic">
                        {{ auth()->user()->roles->first()->name ?? 'Staff' }}
                    </p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="#"
                    class="flex-1 flex items-center justify-center py-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-100 hover:bg-indigo-50/30 transition-all group/set">
                    <i data-lucide="settings"
                        class="w-3.5 h-3.5 group-hover/set:rotate-90 transition-transform duration-500"></i>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center py-2.5 bg-rose-50 rounded-xl text-rose-500 hover:bg-rose-500 hover:text-white transition-all group/out">
                        <i data-lucide="log-out"
                            class="w-3.5 h-3.5 group-hover/out:translate-x-1 transition-transform"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
