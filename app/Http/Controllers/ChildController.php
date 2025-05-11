<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan semua data anak
        $children = Child::with('user')->get();
        return response()->json($children);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika menggunakan view untuk form create
        return view('children.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_anak' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => 'nullable|string|unique:table_child,nik',
        ]);

        // Simpan data anak
        $child = Child::create($validated);

        return response()->json(['message' => 'Child created successfully', 'data' => $child], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menampilkan detail anak
        return response()->json($child->load('user', 'inspections'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Jika menggunakan view untuk form edit
        return view('children.edit', compact('child'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama_anak' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => 'nullable|string|unique:table_child,nik,' . $child->id,
        ]);

        // Update data anak
        $child->update($validated);

        return response()->json(['message' => 'Child updated successfully', 'data' => $child]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Hapus data anak
        $child->delete();

        return response()->json(['message' => 'Child deleted successfully']);
    }
}
