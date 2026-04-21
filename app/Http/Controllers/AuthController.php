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
    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns', 'max:255', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Rate limiting check
        $key = 'login_attempts_' . $request->ip() . '_' . $request->input('email');
        $attempts = cache()->get($key, 0);

        if ($attempts >= 5) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again later.',
            ])->onlyInput('email');
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => 'admin'
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Clear failed attempts on success
            cache()->forget($key);

            // Log successful login
            \Log::info('Admin login successful', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('admin.dashboard');
        }

        // Increment failed attempts
        cache()->put($key, $attempts + 1, now()->addMinutes(15));

        // Log failed login attempt
        \Log::warning('Admin login failed', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'attempts' => $attempts + 1
        ]);

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function loginMember(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email:rfc,dns', 'max:255', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        // Rate limiting check
        $key = 'login_attempts_' . $request->ip() . '_' . $request->input('email');
        $attempts = cache()->get($key, 0);

        if ($attempts >= 5) {
            return back()->withErrors([
                'email' => 'Too many login attempts. Please try again later.',
            ])->onlyInput('email');
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role' => 'member'
        ];

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Clear failed attempts on success
            cache()->forget($key);

            // Log successful login
            \Log::info('Member login successful', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            return redirect()->route('member.dashboard');
        }

        // Increment failed attempts
        cache()->put($key, $attempts + 1, now()->addMinutes(15));

        // Log failed login attempt
        \Log::warning('Member login failed', [
            'email' => $request->input('email'),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'attempts' => $attempts + 1
        ]);

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:9', 'max:12'],
            'address' => ['required', 'string', 'max:500', 'min:10'],
            'password' => ['required', 'confirmed', 'min:8', 'max:128', Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()],
            'selected_services' => ['required', 'array', 'min:1', 'max:10'],
            'selected_services.*' => ['integer', 'exists:services,id'],
        ]);

        // Sanitize input
        $data['name'] = strip_tags(trim($data['name']));
        $data['address'] = strip_tags(trim($data['address']));

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'password' => Hash::make($data['password']),
            'role' => 'member',
            'selected_services' => $data['selected_services'],
        ]);

        // Log successful registration
        \Log::info('Member registration successful', [
            'email' => $data['email'],
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
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
