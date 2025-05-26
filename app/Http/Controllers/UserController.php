<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role') && in_array($request->role, ['admin', 'petugas', 'orangtua'])) {
            $query->where('role', $request->role);
        }

        if ($request->filled('verifikasi') && in_array($request->verifikasi, ['waiting', 'approved', 'rejected'])) {
            $query->where('verifikasi', $request->verifikasi);
        }

        // Apply search filter if provided
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm);
            });
        }

        // Get the filtered users
        $users = $query->get();

        // Return the index view with the filtered results and query parameters
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
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,petugas,orangtua',
            'phone'    => 'nullable|string|max:15',
            'address'  => 'nullable|string',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['verifikasi'] = 'waiting';

        User::create($validated);

        return redirect()->route('dashboard.admin.user.index')->with('success', 'User berhasil ditambahkan.');
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
        // Validate incoming request data
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'password'    => 'nullable|string|min:8|confirmed',
            'role'        => 'required|in:admin,petugas,orangtua',
            'phone'       => 'nullable|string|max:15',
            'address'     => 'nullable|string',
            'status_akun' => 'required|in:waiting,approved,rejected',
        ]);

        // If password is provided, hash it; otherwise, leave it unchanged
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Update the user with the validated data
        $user->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'role'       => $validated['role'],
            'phone'      => $validated['phone'],
            'address'    => $validated['address'],
            'verifikasi' => $validated['status_akun'],
            'password'   => $validated['password'] ?? $user->password,
        ]);

        // Redirect back to the user index with success message
        return redirect()->route('dashboard.admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        // Redirect back to user index with success message
        return redirect()->route('dashboard.admin.user.index')->with('success', 'User berhasil dihapus.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status_akun' => 'required|in:approved,rejected',
        ]);

        $user->verifikasi = $request->status_akun;
        $user->save();

        // Redirect back to user index with success message
        return redirect()->route('dashboard.admin.user.index')->with('success', 'Status verifikasi berhasil diperbarui.');
    }
}
