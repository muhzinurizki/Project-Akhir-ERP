<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Perbaikan: Gunakan Facade

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles');
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $query->latest()->paginate(10)->withQueryString();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', 'exists:roles,name'],
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                $baseUsername = Str::before($validated['email'], '@');
                $username = $baseUsername;
                $counter = 1;
                while (User::where('username', $username)->exists()) {
                    $username = $baseUsername . $counter++;
                }

                $user = User::create([
                    'name'      => $validated['name'],
                    'email'     => $validated['email'],
                    'username'  => $username,
                    'password'  => Hash::make($validated['password']),
                    'is_active' => true,
                ]);

                $user->assignRole($validated['role']);

                // Perbaikan: Gunakan Facade Auth dan Type Hinting untuk Intelephense
                /** @var \App\Models\User $currentUser */
                $currentUser = Auth::user();
                Log::info("User Created by {$currentUser->name}: {$user->username}");

                return redirect()->route('users.index')->with('success', "User berhasil dibuat.");
            });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', 'Gagal menyimpan user.');
        }
    }

    public function toggleStatus(User $user)
    {
        // Perbaikan: Gunakan Auth::id()
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak bisa menonaktifkan diri sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status user diperbarui.');
    }

    public function destroy(User $user)
    {
        // Perbaikan: Gunakan Auth::id()
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak bisa menghapus diri sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User dihapus.');
    }
}