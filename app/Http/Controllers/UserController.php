<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Apply role filter if provided
        if ($request->filled('role') && in_array($request->role, ['admin', 'petugas', 'orangtua'])) {
            $query->where('role', $request->role);
        }

        // Apply verification status filter if provided
        if ($request->filled('verifikasi') && in_array($request->verifikasi, ['waiting', 'approved', 'rejected'])) {
            $query->where('verifikasi', $request->verifikasi);
        }

        // Apply search filter if provided (by name, email, or phone)
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm);
            });
        }

        // Paginate and keep query string for pagination links
        $users = $query->paginate(10)->withQueryString();

        return view('dashboard.admin.users.index', compact('users'))
            ->with('selectedRole', $request->role)
            ->with('searchTerm', $request->search)
            ->with('selectedVerifikasi', $request->verifikasi);
    }

    public function create()
    {
        return view('dashboard.admin.users.create');
    }

    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,petugas,orangtua',
            'phone'    => 'nullable|string|max:15',
            'address'  => 'nullable|string',
        ]);

        // Encrypt password and set verification status to 'waiting'
        $validated['password'] = bcrypt($validated['password']);
        $validated['verifikasi'] = 'waiting';

        // Create new user
        User::create($validated);

        // Redirect back to user index with success message
        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        return view('dashboard.admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('dashboard.admin.users.edit', compact('user'));
    }

public function update(Request $request, User $user)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role' => 'required|string|in:admin,petugas,orangtua',
        'phone' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'verifikasi' => 'required|in:waiting,approved,rejected', // tambahkan ini
    ]);

    if (!$request->filled('password')) {
        unset($validated['password']);
    }

    $user->update($validated);

    return redirect()->route('user.index')->with('success', 'Pengguna berhasil diperbarui.');
}


    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();
        
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }

    public function updateStatus(Request $request, User $user)
    {
        // Validate incoming request data for status update
        $request->validate([
            'status_akun' => 'required|in:approved,rejected',
        ]);

        // Update the verification status of the user
        $user->verifikasi = $request->status_akun;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Status verifikasi berhasil diperbarui.');
    }
}