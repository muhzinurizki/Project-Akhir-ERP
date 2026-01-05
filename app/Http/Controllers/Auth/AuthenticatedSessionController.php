<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Tangani permintaan otentikasi.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input dasar
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Cek Rate Limiting (Mencegah brute force)
        $this->ensureIsNotRateLimited($request);

        $loginValue = $request->input('login');
        
        // 3. Logika Penentuan Tipe Login (Email, NIK, atau Username)
        if (filter_var($loginValue, FILTER_VALIDATE_EMAIL)) {
            $fieldType = 'email';
        } elseif (str_starts_with(strtoupper($loginValue), 'EMP-')) {
            $fieldType = 'employee_code';
        } else {
            $fieldType = 'username';
        }

        $credentials = [
            $fieldType => $loginValue,
            'password' => $request->password,
        ];

        // 4. Proses Attempt Login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            
            // 5. Cek Status Akun (is_active)
            if (!Auth::user()->is_active) {
                Auth::logout();
                
                // Hapus throttle jika gagal karena status non-aktif
                RateLimiter::clear($this->throttleKey($request));

                return back()->withErrors([
                    'login' => 'Akses ditolak. Akun Anda telah dinonaktifkan oleh administrator.',
                ]);
            }

            // Login sukses: Reset limiter & Regenerasi session
            RateLimiter::clear($this->throttleKey($request));
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // 6. Jika Gagal: Tambah hit ke Rate Limiter & Lempar Exception
        RateLimiter::hit($this->throttleKey($request));

        throw ValidationException::withMessages([
            'login' => __('auth.failed'),
        ]);
    }

    /**
     * Hapus sesi (Logout).
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Logika Pembatasan Login (Throttle).
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'login' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Kunci identitas untuk Rate Limiter.
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('login')).'|'.$request->ip());
    }
}