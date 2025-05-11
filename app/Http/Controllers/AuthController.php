<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        return response()->json(['message' => 'User registered successfully', 'data' => $user], 201);
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
                'admin' => redirect()->route('admin.dashboard'),
                'petugas' => redirect()->route('petugas.dashboard'),
                'orangtua' => redirect()->route('orangtua.dashboard'),
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
        // Hapus token autentikasi
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful']);
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
