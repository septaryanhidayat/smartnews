<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Guarantee essential accounts exist with password 'password'
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('users')) {
                if (User::where('role', 'admin')->count() === 0) {
                    User::updateOrCreate(
                        ['email' => 'admin@smartnews.id'],
                        [
                            'name' => 'Super Administrator',
                            'role' => 'admin',
                            'password' => Hash::make('password'),
                            'email_verified_at' => now(),
                        ]
                    );
                    User::updateOrCreate(
                        ['email' => 'info@berandadigital.net'],
                        [
                            'name' => 'Budi Santoso',
                            'role' => 'admin',
                            'password' => Hash::make('password'),
                            'email_verified_at' => now(),
                        ]
                    );
                    User::updateOrCreate(
                        ['email' => 'redaksi@smartnews.id'],
                        [
                            'name' => 'Siti Nurhaliza',
                            'role' => 'editor',
                            'password' => Hash::make('password'),
                            'email_verified_at' => now(),
                        ]
                    );
                    User::updateOrCreate(
                        ['email' => 'wartawan@smartnews.id'],
                        [
                            'name' => 'Ahmad Fauzi (Wartawan)',
                            'role' => 'author',
                            'password' => Hash::make('password'),
                            'email_verified_at' => now(),
                        ]
                    );
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $isFirst = User::where('role', 'admin')->count() === 0;

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $isFirst ? 'admin' : 'author',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang! Akun Anda berhasil didaftarkan.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah berhasil keluar.');
    }
}
