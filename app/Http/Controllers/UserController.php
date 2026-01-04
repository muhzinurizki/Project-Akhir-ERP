<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', 'exists:roles,name'],
        ]);

        // 👉 Generate username otomatis dari email
        $baseUsername = Str::before($validated['email'], '@');
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'username' => $username,
            'password' => Hash::make($validated['password']),
        ]);

        // Assign role
        $user->assignRole($validated['role']);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'role'     => ['required', 'exists:roles,name'],
        ]);

        $user->update([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password']
                ? Hash::make($validated['password'])
                : $user->password,
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
