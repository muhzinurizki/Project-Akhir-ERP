<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | ERP Tekstil</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .login-animate { animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1); }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .loader { border: 2px solid #f3f3f3; border-top: 2px solid #1e293b; border-radius: 50%; width: 16px; height: 16px; animation: spin 1s linear infinite; display: none; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F8FAFC] flex items-center justify-center p-4 sm:p-6">

    <div class="login-animate w-full max-w-[1100px] bg-white shadow-[0_40px_100px_rgba(15,23,42,0.08)] rounded-[3rem] overflow-hidden grid grid-cols-1 lg:grid-cols-2 min-h-[700px]">

        {{-- LEFT SIDE: Branding --}}
        <div class="hidden lg:flex flex-col justify-between p-20 bg-slate-900 text-white relative overflow-hidden">
            <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-500/20 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute bottom-[-5%] right-[-5%] w-80 h-80 bg-emerald-500/10 rounded-full blur-[100px]"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-16">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-emerald-400 flex items-center justify-center shadow-lg font-black text-2xl text-slate-900">E</div>
                    <span class="text-2xl font-black tracking-tighter uppercase italic">ERP Tekstil</span>
                </div>
                <h1 class="text-5xl font-black leading-[1.1] tracking-tighter uppercase">
                    Kelola Produksi <br>
                    <span class="text-slate-500 italic text-4xl font-extrabold">Akurasi Tanpa Batas.</span>
                </h1>
            </div>

            <div class="relative z-10 space-y-8">
                <div class="flex items-center gap-5 group cursor-default">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center border border-white/10 group-hover:bg-emerald-500 transition-all duration-500">
                        <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em]">Security</p>
                        <p class="text-sm font-bold text-slate-200">Industrial Encryption</p>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10 pointer-events-none"></div>
        </div>

        {{-- RIGHT SIDE: Form --}}
        <div class="flex items-center justify-center p-10 md:p-20 relative bg-white">
            <div class="w-full max-w-[380px]">
                <div class="mb-12">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Login Portal</h2>
                    <p class="mt-3 text-sm text-slate-500 font-medium">Masuk untuk mengelola operasional.</p>
                </div>

                {{-- Pesan Error --}}
                @if ($errors->any())
                <div class="mb-6 p-4 bg-rose-50 border border-rose-100 rounded-2xl">
                    @foreach ($errors->all() as $error)
                        <div class="flex items-center gap-3 text-rose-600 mb-1 last:mb-0">
                            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                            <p class="text-[11px] font-bold uppercase tracking-wider">{{ $error }}</p>
                        </div>
                    @endforeach
                </div>
                @endif

                {{-- FORM MULAI --}}
                <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-6">
                    @csrf {{-- CSRF HARUS SETELAH FORM --}}

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Identitas (Email / NIK / Username)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="user" class="h-4 w-4 text-slate-300 group-focus-within:text-slate-900"></i>
                            </div>
                            <input type="text" name="login" value="{{ old('login') }}" required autofocus
                                class="w-full pl-12 pr-6 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] focus:bg-white focus:ring-8 focus:ring-slate-900/5 focus:border-slate-900 transition-all duration-300 text-sm font-bold outline-none"
                                placeholder="Masukkan Email atau NIK..." />
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Kata Sandi</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                <i data-lucide="lock" class="h-4 w-4 text-slate-300 group-focus-within:text-slate-900"></i>
                            </div>
                            <input type="password" name="password" id="passwordInput" required
                                class="w-full pl-12 pr-14 py-4 bg-slate-50 border border-slate-100 rounded-[1.25rem] focus:bg-white focus:ring-8 focus:ring-slate-900/5 focus:border-slate-900 transition-all duration-300 text-sm font-bold outline-none"
                                placeholder="••••••••" />
                            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-5 flex items-center text-slate-300 hover:text-slate-900">
                                <i data-lucide="eye" id="eyeIcon" class="h-4 w-4"></i>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between px-1">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="remember" class="h-4 w-4 text-slate-900 border-slate-200 rounded">
                            <span class="ml-2 text-xs text-slate-500 font-bold">Ingat Saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-[11px] text-slate-400 hover:text-slate-900 font-bold uppercase tracking-wider">Lupa?</a>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full bg-slate-900 text-white py-5 rounded-[1.25rem] hover:bg-slate-800 transition-all duration-300 text-xs font-black uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                        <span id="btnText">Masuk Ke Sistem</span>
                        <div class="loader" id="btnLoader"></div>
                        <i data-lucide="arrow-right" id="btnIcon" class="w-4 h-4"></i>
                    </button>
                </form>

                <div class="mt-16 pt-8 border-t border-slate-50 text-center">
                    <p class="text-[9px] text-slate-400 font-black uppercase tracking-[0.3em]">
                        &copy; {{ date('Y') }} ERP Tekstil Industrial System
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();

        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        const form = document.getElementById('loginForm');
        form.addEventListener('submit', () => {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('btnText').innerText = 'Memproses...';
            document.getElementById('btnLoader').style.display = 'block';
            document.getElementById('btnIcon').style.display = 'none';
        });
    </script>
</body>
</html>