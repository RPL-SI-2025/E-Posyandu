<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan semua data pemeriksaan dengan relasi anak dan jadwal
        $inspections = Inspection::with(['child', 'eventtime', 'user'])->get();
        return response()->json($inspections);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika menggunakan view untuk form create
        $children = Child::all();
        $eventtimes = Eventtime::all();
        return view('inspections.create', compact('children', 'eventtimes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'table_child_id' => 'required|exists:table_child,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'eventtime_id' => 'required|exists:table_eventtime,id',
        ]);

        // Simpan data pemeriksaan
        $inspection = Inspection::create($validated);

        return response()->json(['message' => 'Inspection created successfully', 'data' => $inspection], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inspection $inspection)
    {
        // Menampilkan detail pemeriksaan dengan relasi
        return response()->json($inspection->load(['child', 'eventtime', 'user']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inspection $inspection)
    {
        // Jika menggunakan view untuk form edit
        $children = Child::all();
        $eventtimes = Eventtime::all();
        return view('inspections.edit', compact('inspection', 'children', 'eventtimes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inspection $inspection)
    {
        // Validasi input
        $validated = $request->validate([
            'table_child_id' => 'required|exists:table_child,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'lingkar_kepala' => 'nullable|numeric|min:0',
            'catatan' => 'nullable|string',
            'eventtime_id' => 'required|exists:table_eventtime,id',
        ]);

        // Update data pemeriksaan
        $inspection->update($validated);

        return response()->json(['message' => 'Inspection updated successfully', 'data' => $inspection]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        // Hapus data pemeriksaan
        $inspection->delete();

        return response()->json(['message' => 'Inspection deleted successfully']);
    }
}
