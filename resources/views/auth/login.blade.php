<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ERP Tekstil</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Smooth transition untuk hover state */
        .login-card { transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1); }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC] flex items-center justify-center p-4 sm:p-6">

    <div class="w-full max-w-[1100px] bg-white shadow-[0_40px_100px_rgba(15,23,42,0.08)] rounded-[3rem] overflow-hidden grid grid-cols-1 lg:grid-cols-2 min-h-[700px]">

        {{-- LEFT: Branding (Premium Slate Design) --}}
        <div class="hidden lg:flex flex-col justify-between p-20 bg-slate-900 text-white relative overflow-hidden">
            {{-- Animated Decorative Orbs --}}
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-[-5%] right-[-5%] w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px]"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-16">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-emerald-400 flex items-center justify-center shadow-lg font-black text-2xl text-slate-900">
                        E
                    </div>
                    <span class="text-2xl font-black tracking-tighter uppercase italic">ERP Tekstil</span>
                </div>

                <h1 class="text-5xl font-black leading-[1.1] tracking-tighter">
                    KELOLA PRODUKSI <br>
                    <span class="text-slate-500 italic uppercase text-4xl">DENGAN AKURASI TINGGI.</span>
                </h1>
                <p class="mt-8 text-slate-400 text-lg font-medium leading-relaxed max-w-sm italic">
                    Efisiensi hulu ke hilir dalam satu genggaman. Pantau stok, gudang, dan suplai secara real-time.
                </p>
            </div>

            <div class="relative z-10 space-y-8">
                <div class="flex items-center gap-5 group cursor-default">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-emerald-500 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-0.5">Security</p>
                        <p class="text-sm font-bold text-slate-200">Enterprise Data Encryption</p>
                    </div>
                </div>
                <div class="flex items-center gap-5 group cursor-default">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-indigo-500 group-hover:scale-110 transition-all duration-500 shadow-xl">
                        <i data-lucide="zap" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-0.5">Performance</p>
                        <p class="text-sm font-bold text-slate-200">Automated Logistics Sync</p>
                    </div>
                </div>
            </div>
            
            {{-- Subtle texture overlay --}}
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 pointer-events-none"></div>
        </div>

        {{-- RIGHT: Login Form --}}
        <div class="flex items-center justify-center p-10 md:p-20 relative bg-white">
            <div class="w-full max-w-[380px]">
                <div class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Selamat Datang</h2>
                    <p class="mt-3 text-sm text-slate-500 font-medium">Otentikasi diperlukan untuk mengakses sistem manajemen.</p>
                </div>

                @if (session('status'))
                <div class="mb-8 text-xs text-emerald-700 bg-emerald-50 p-4 rounded-2xl border border-emerald-100 font-black uppercase tracking-wider flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-4 h-4"></i>
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">
                            Email Identifikasi
                        </label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="user" class="h-4 w-4 text-slate-300 group-focus-within:text-slate-900 transition-colors"></i>
                            </div>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] focus:bg-white focus:ring-8 focus:ring-slate-900/5 focus:border-slate-900 transition-all duration-300 text-sm font-bold outline-none"
                                placeholder="nama@perusahaan.com" />
                        </div>
                        @error('email')
                        <p class="text-[10px] text-rose-500 mt-2 ml-1 font-bold uppercase italic tracking-wider">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                                Kata Sandi
                            </label>
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="key-round" class="h-4 w-4 text-slate-300 group-focus-within:text-slate-900 transition-colors"></i>
                            </div>
                            <input type="password" name="password" required
                                class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] focus:bg-white focus:ring-8 focus:ring-slate-900/5 focus:border-slate-900 transition-all duration-300 text-sm font-bold outline-none"
                                placeholder="••••••••" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember"
                                class="h-4 w-4 text-slate-900 focus:ring-slate-900 border-slate-200 rounded-lg transition-all cursor-pointer">
                            <label for="remember" class="ml-2 text-xs text-slate-500 font-bold cursor-pointer select-none">Ingat Perangkat</label>
                        </div>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[11px] text-slate-400 hover:text-indigo-600 font-black uppercase tracking-wider transition-colors">
                            Reset?
                        </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full bg-slate-900 text-white py-5 rounded-[1.25rem] hover:bg-slate-800 active:scale-[0.98] transition-all duration-300 text-xs font-black uppercase tracking-[0.2em] shadow-2xl shadow-slate-200 flex items-center justify-center gap-3 group">
                        Masuk ke Sistem
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <div class="mt-16 pt-8 border-t border-slate-50 text-center">
                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.3em] italic">
                        &copy; {{ date('Y') }} ERP Tekstil Industrial System v2.0
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