<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
// Import untuk Arsitektur Middleware Laravel Terbaru
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Daftarkan Middleware menggunakan static method (Standar Laravel 11/12)
     */
    public static function middleware(): array
    {
        return [
            // Hanya user dengan permission ini yang bisa akses semua method di controller ini
            new Middleware('permission:user.manage'),
        ];
    }

    public function index()
    {
        $roles = Role::withCount(['permissions', 'users'])->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function($perm) {
            return Str::before($perm->name, '.'); 
        });
        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'nullable|array'
        ]);

        try {
            DB::transaction(function () use ($request) {
                $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
                if ($request->has('permissions')) {
                    $role->syncPermissions($request->permissions);
                }
            });
            return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error("Error Store Role: " . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menyimpan role.');
        }
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(fn($perm) => Str::before($perm->name, '.'));
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array'
        ]);

        try {
            DB::transaction(function () use ($request, $role) {
                $role->update(['name' => $request->name]);
                $role->syncPermissions($request->permissions ?? []);
            });
            return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal update role.');
        }
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role masih digunakan oleh user.');
        }
        if ($role->name === 'Admin') {
            return back()->with('error', 'Role Admin sistem tidak boleh dihapus.');
        }
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role dihapus.');
    }
}