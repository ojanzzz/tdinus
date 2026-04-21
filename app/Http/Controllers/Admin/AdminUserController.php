<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.admin-users.index', [
            'admins' => User::where('role', 'admin')->orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.admin-users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)->mixedCase()->numbers()->symbols()],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function edit(User $admin_user)
    {
        return view('admin.admin-users.edit', [
            'admin' => $admin_user,
        ]);
    }

    public function update(Request $request, User $admin_user)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $admin_user->id],
            'password' => ['nullable', 'confirmed', Password::min(6)->mixedCase()->numbers()->symbols()],
        ]);

        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $admin_user->update($updateData);

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $admin_user)
    {
        // Prevent deleting the current admin
        if ($admin_user->id === auth()->id()) {
            return redirect()->route('admin.admin-users.index')
                ->with('error', 'Tidak dapat menghapus admin yang sedang login.');
        }

        $admin_user->delete();

        return redirect()->route('admin.admin-users.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}
