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
    {{-- NAVIGATION --}}
    <nav class="flex-1 overflow-y-auto px-4 py-4 space-y-1 custom-scrollbar">
        @php
            $sidebarMenus = [
                ['route' => 'dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard', 'perm' => null],

                ['header' => 'Master Data', 'perm' => 'master.view'],
                ['route' => 'products.index', 'icon' => 'package', 'label' => 'Products', 'perm' => 'master.view'],
                ['route' => 'suppliers.index', 'icon' => 'truck', 'label' => 'Suppliers', 'perm' => 'master.view'],
                [
                    'route' => 'customers.index',
                    'icon' => 'users-round',
                    'label' => 'Customers',
                    'perm' => 'master.view'
                ],

                ['header' => 'Inventory', 'perm' => 'inventory.view'],
                [
                    'route' => 'inventory.index',
                    'icon' => 'boxes',
                    'label' => 'Stock Ledger',
                    'perm' => 'inventory.view'
                ],
                [
                    'route' => 'inventory.create',
                    'icon' => 'plus-square',
                    'label' => 'Stock Entry',
                    'perm' => 'inventory.transfer'
                ],

                ['header' => 'Procurement', 'perm' => 'purchase_request.view'],
                [
                    'route' => 'purchase-requests.index',
                    'icon' => 'clipboard-list',
                    'label' => 'Purchase Request',
                    'perm' => 'purchase_request.view'
                ],
                [
                    'route' => 'purchase-orders.index',
                    'icon' => 'shopping-bag',
                    'label' => 'Purchase Order',
                    'perm' => 'purchase_order.create'
                ],

                ['header' => 'Sales', 'perm' => 'sales_order.approve'],
                [
                    'route' => 'sales-orders.index',
                    'icon' => 'file-spreadsheet',
                    'label' => 'Sales Order',
                    'perm' => 'sales_order.approve'
                ],
                [
                    'route' => 'delivery-orders.index',
                    'icon' => 'truck',
                    'label' => 'Delivery Order',
                    'perm' => 'delivery_order.create'
                ],

                ['header' => 'Administration', 'perm' => 'user.manage'],
                ['route' => 'users.index', 'icon' => 'users', 'label' => 'User List', 'perm' => 'user.manage'],
                [
                    'route' => 'roles.index',
                    'icon' => 'shield-check',
                    'label' => 'Roles & Permissions',
                    'perm' => 'user.manage'
                ]
            ];
        @endphp

        @foreach ($sidebarMenus as $menu)
            @if (isset($menu['header']))
                @can($menu['perm'])
                    <div class="pt-6 pb-2 px-4">
                        <p
                            class="text-[9px] font-black text-slate-300 uppercase tracking-[0.3em] italic leading-none border-l-2 border-slate-100 pl-3">
                            {{ $menu['header'] }}
                        </p>
                    </div>
                @endcan
            @else
                @if ($menu['perm'] == null || auth()->user()->can($menu['perm']))
                    @php $isActive = request()->routeIs($menu['route'] . '*'); @endphp
                    <a href="{{ route($menu['route']) }}"
                        class="group flex items-center justify-between px-3 py-2.5 rounded-[1.25rem] transition-all duration-300
                          {{ $isActive ? 'bg-slate-900 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50' }}">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-9 h-9 rounded-xl flex items-center justify-center {{ $isActive ? 'bg-indigo-500/20' : 'bg-slate-50' }}">
                                <i data-lucide="{{ $menu['icon'] }}"
                                    class="w-4 h-4 {{ $isActive ? 'text-indigo-400' : 'text-slate-400' }}"></i>
                            </div>
                            <span
                                class="text-[11px] font-black uppercase italic {{ $isActive ? 'text-white' : 'text-slate-600' }}">
                                {{ $menu['label'] }}
                            </span>
                        </div>
                    </a>
                @endif
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
                        class="text-[11px] font-bold text-slate-900 truncate uppercase italic tracking-tighter leading-none">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-[9px] text-indigo-500 font-black uppercase tracking-[0.15em] mt-1 italic">
                        {{-- Menampilkan Role Pertama User secara aman --}}
                        {{ auth()->user()->roles->first()->name ?? 'No Role' }}
                    </p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('profile.edit') }}"
                    class="flex-1 flex items-center justify-center py-2.5 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 transition-all">
                    <i data-lucide="settings" class="w-3.5 h-3.5"></i>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center py-2.5 bg-rose-50 rounded-xl text-rose-500 hover:bg-rose-500 hover:text-white transition-all">
                        <i data-lucide="log-out" class="w-3.5 h-3.5"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
