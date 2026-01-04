<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ERP Tekstil</title>
    {{-- Menggunakan font Plus Jakarta Sans agar konsisten dengan dashboard --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC] flex items-center justify-center p-4">

    <div
        class="w-full max-w-[1100px] min-h-[640px] bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[2.5rem] overflow-hidden grid grid-cols-1 lg:grid-cols-2">

        {{-- LEFT: Branding (Premium Slate Design) --}}
        <div class="hidden lg:flex flex-col justify-between p-16 bg-slate-900 text-white relative overflow-hidden">
            {{-- Decorative Elements --}}
            <div class="absolute top-[-10%] left-[-10%] w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-5%] right-[-5%] w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px]"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-12">
                    <div
                        class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/20 font-bold text-xl">
                        E
                    </div>
                    <span class="text-xl font-bold tracking-tight">ERP Tekstil</span>
                </div>

                <h1 class="text-4xl font-extrabold leading-[1.2] tracking-tight">
                    Kelola Produksi <br>
                    <span class="text-slate-400">Lebih Terstruktur.</span>
                </h1>
                <p class="mt-6 text-slate-400 text-lg font-medium leading-relaxed max-w-sm">
                    Satu platform untuk mengontrol seluruh rantai produksi tekstil dari hulu ke hilir.
                </p>
            </div>

            <div class="relative z-10 space-y-6">
                <div class="flex items-center gap-4 group">
                    <div
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-emerald-500 transition-colors duration-500">
                        <i data-lucide="shield-check" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-300">Enterprise Grade Security</span>
                </div>
                <div class="flex items-center gap-4 group">
                    <div
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-indigo-500 transition-colors duration-500">
                        <i data-lucide="bar-chart-3" class="w-5 h-5 text-white"></i>
                    </div>
                    <span class="text-sm font-semibold text-slate-300">Real-time Analytics Dashboard</span>
                </div>
            </div>
        </div>

        {{-- RIGHT: Login Form --}}
        <div class="flex items-center justify-center p-8 md:p-16">
            <div class="w-full max-w-[360px]">
                <div class="mb-10">
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Login</h2>
                    <p class="mt-2 text-sm text-slate-500 font-medium">Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                <div
                    class="mb-6 text-sm text-emerald-600 bg-emerald-50 p-4 rounded-2xl border border-emerald-100 font-semibold">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-[13px] font-bold text-slate-700 mb-2 ml-1 uppercase tracking-wider">
                            Email Address
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="mail"
                                    class="h-5 w-5 text-slate-400 group-focus-within:text-slate-900 transition-colors"></i>
                            </div>
                            <input type="email" name="email" required autofocus
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all duration-200 text-sm font-medium outline-none"
                                placeholder="nama@perusahaan.com" />
                        </div>
                        @error('email')
                        <p class="text-xs text-rose-500 mt-2 ml-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2 ml-1">
                            <label class="text-[13px] font-bold text-slate-700 uppercase tracking-wider">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-[12px] text-slate-400 hover:text-slate-900 font-bold transition-colors">
                                Lupa Password?
                            </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i data-lucide="lock"
                                    class="h-5 w-5 text-slate-400 group-focus-within:text-slate-900 transition-colors"></i>
                            </div>
                            <input type="password" name="password" required
                                class="w-full pl-12 pr-4 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all duration-200 text-sm font-medium outline-none"
                                placeholder="••••••••" />
                        </div>
                    </div>

                    <div class="flex items-center ml-1">
                        <input type="checkbox" name="remember" id="remember"
                            class="h-4 w-4 text-slate-900 focus:ring-slate-900 border-slate-200 rounded-md">
                        <label for="remember"
                            class="ml-2 text-sm text-slate-500 font-medium cursor-pointer select-none">Ingat perangkat
                            ini</label>
                    </div>

                    <button type="submit"
                        class="w-full bg-slate-900 text-white py-4 rounded-2xl hover:bg-slate-800 active:scale-[0.98] transition-all duration-200 text-sm font-bold shadow-xl shadow-slate-200 flex items-center justify-center gap-2">
                        Masuk ke Sistem
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>

                <div class="mt-12 pt-8 border-t border-slate-50 text-center">
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-[0.2em]">
                        &copy; {{ date('Y') }} ERP Tekstil v2.0
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>