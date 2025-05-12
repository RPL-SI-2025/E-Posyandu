<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,petugas,orangtua',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // Simpan pengguna baru
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        // Assign role using Spatie
        $user->assignRole($validated['role']);

        return redirect()->route('login')->with('success', 'Registration successful! Please login to continue.');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Cek kredensial
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Arahkan ke dashboard sesuai role
            $role = Auth::user()->role;

            return match ($role) {
                'admin' => redirect()->route('dashboard.admin.index'),
                'petugas' => redirect()->route('dashboard.petugas.index'),
                'orangtua' => redirect()->route('dashboard.orangtua.index'),
                default => redirect('/'),
            };
        }

        // Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }

    /**
     * Get the authenticated user.
     */
    public function me(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Mengarahkan ke view auth/login.blade.php
    }

    /**
     * Tampilkan halaman register.
     */
    public function showRegisterForm()
    {
        return view('auth.register'); // Mengarahkan ke view auth/register.blade.php
    }
}
