<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with base query
        $query = User::query();
        
        // Filter by role if specified
        if ($request->filled('role') && in_array($request->role, ['admin', 'petugas', 'orangtua'])) {
            $query->where('role', $request->role);
        }
        
        // Search by name, email, or phone if search term is provided
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm);
            });
        }
        
        // Get users with applied filters and search
        $users = $query->get();
        
        // Pass the current filter values to the view for form persistence
        return view('dashboard.admin.users.index', compact('users'))
            ->with('selectedRole', $request->role)
            ->with('searchTerm', $request->search);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        // Hash the password before storing
        $validated['password'] = bcrypt($validated['password']);

        // Create user
        $user = User::create($validated);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('dashboard.admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,petugas,orangtua',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // Jika password dikosongkan, jangan update field password
        if (!$request->filled('password')) {
            unset($validated['password']);
        } else {
            // Hash the password if provided
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus.');
    }
}