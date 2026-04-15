<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin(string $role)
    {
        if (!in_array($role, ['admin', 'member'], true)) {
            abort(404);
        }

        $isRegister = request()->query('register') === '1';
        $services = $role === 'member' ? Service::pluck('name', 'id')->toArray() : [];
        return view('auth.login', ['role' => $role, 'services' => $services, 'isRegister' => $isRegister]);
    }

    public function login(Request $request, string $role)
    {
        if (!in_array($role, ['admin', 'member'], true)) {
            abort(404);
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['role'] = $role;

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('member.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai untuk role ini.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
'phone' => ['required', 'numeric', 'digits_between:9,12'],
            'address' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(6)->mixedCase()->numbers()->symbols()],
            'selected_services' => ['required', 'array', 'min:1'],
            'selected_services.*' => ['exists:services,id'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'role' => 'member',
            'selected_services' => $data['selected_services'],
        ]);

        return back()->with('success', 'Daftar berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

