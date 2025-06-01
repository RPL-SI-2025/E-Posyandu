<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserPetugasController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Filter hanya user role orangtua
        $query->where('role', 'orangtua');

        if ($request->filled('verifikasi') && in_array($request->verifikasi, ['waiting', 'approved', 'rejected'])) {
            $query->where('verifikasi', $request->verifikasi);
        }

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)
                  ->orWhere('email', 'like', $searchTerm)
                  ->orWhere('phone', 'like', $searchTerm);
            });
        }

        $users = $query->get();

        return view('dashboard.petugas.user.index', [
            'users' => $users,
            'selectedVerifikasi' => $request->verifikasi,
            'searchTerm' => $request->search,
        ]);
    }

    public function create()
    {
        return view('dashboard.petugas.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone'    => 'nullable|string|max:15',
            'address'  => 'nullable|string',
        ]);

        $validated['password']   = bcrypt($validated['password']);
        $validated['role']       = 'orangtua';      // otomatis jadi orangtua
        $validated['verifikasi'] = 'waiting';       // otomatis waiting abu-abu

        User::create($validated);

        return redirect()->route('dashboard.petugas.user.index')
            ->with('success', 'Akun orangtua berhasil dibuat dengan status verifikasi menunggu.');
    }


    public function edit(User $user)
    {
        return view('dashboard.petugas.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email,' . $user->id,
            'password'    => 'nullable|string|min:8|confirmed',
            'role'        => 'required|in:admin,petugas,orangtua',
            'phone'       => 'nullable|string|max:15',
            'address'     => 'nullable|string',
            'status_akun' => 'required|in:waiting,approved,rejected',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'role'       => $validated['role'],
            'phone'      => $validated['phone'],
            'address'    => $validated['address'],
            'verifikasi' => $validated['status_akun'],
            'password'   => $validated['password'] ?? $user->password,
        ]);

        return redirect()->route('dashboard.petugas.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('dashboard.petugas.user.index')->with('success', 'User berhasil dihapus.');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status_akun' => 'required|in:approved,rejected',
        ]);

        
        $user->verifikasi = $request->status_akun;
        $user->save();

        return redirect()->route('dashboard.petugas.user.index')->with('success', 'Status verifikasi berhasil diperbarui.');
    }
}
