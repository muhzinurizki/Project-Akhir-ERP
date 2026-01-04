<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ERP Tekstil')</title>

    {{-- Fonts: Inter/Plus Jakarta Sans sangat populer untuk UI Premium --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar Modern */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#F8FAFC] text-slate-900 antialiased min-h-screen selection:bg-slate-900 selection:text-white">

    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen relative">

        {{-- Mobile overlay dengan Blur --}}
        <div x-show="sidebarOpen" x-transition:enter="transition opacity-ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition opacity-ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden" x-cloak>
        </div>

        {{-- Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Wrapper --}}
        <div class="flex flex-col flex-1 lg:pl-0 transition-all duration-300 w-full min-w-0 lg:ml-64">

            {{-- Topbar --}}
            @include('layouts.topbar')

            {{-- Main Content --}}
            <main class="flex-1 overflow-x-hidden">
                {{-- Container untuk menjaga konten tidak terlalu lebar di monitor ultra-wide --}}
                <div class="max-w-[1600px] mx-auto p-6 md:p-8">

                    {{-- Slot for Flash Messages (Alerts) --}}
                    @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                        class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-between">
                        <div class="flex items-center gap-3 font-semibold text-sm">
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                            {{ session('success') }}
                        </div>
                        <button @click="show = false"><i data-lucide="x" class="w-4 h-4"></i></button>
                    </div>
                    @endif

                    {{-- Konten Utama --}}
                    <div class="transition-all duration-500">
                        @yield('content')
                    </div>
                </div>
            </main>

            {{-- Footer Sederhana --}}
            <footer class="px-8 py-6 border-t border-slate-100 bg-white/50">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-xs text-slate-500 font-medium">
                        &copy; {{ date('Y') }} ERP Tekstil Enterprise. All rights reserved.
                    </p>
                    <div class="flex items-center gap-6 text-xs font-semibold text-slate-400">
                        <a href="#" class="hover:text-slate-900 transition-colors">Support</a>
                        <a href="#" class="hover:text-slate-900 transition-colors">Changelog</a>
                    </div>
                </div>
            </footer>

        </div>

    </div>

    {{-- Initialize Lucide Icons --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        lucide.createIcons();
    });
    </script>

</body>

</html>