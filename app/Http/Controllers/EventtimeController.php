<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan semua data eventtime
        $eventtimes = Eventtime::all();
        return response()->json($eventtimes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika menggunakan view untuk form create
        return view('eventtime.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan data eventtime
        $eventtime = Eventtime::create($validated);

        return response()->json(['message' => 'Eventtime created successfully', 'data' => $eventtime], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Eventtime $eventtime)
    {
        // Menampilkan detail eventtime
        return response()->json($eventtime);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Eventtime $eventtime)
    {
        // Jika menggunakan view untuk form edit
        return view('eventtime.edit', compact('eventtime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eventtime $eventtime)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        // Update data eventtime
        $eventtime->update($validated);

        return response()->json(['message' => 'Eventtime updated successfully', 'data' => $eventtime]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eventtime $eventtime)
    {
        // Hapus data eventtime
        $eventtime->delete();

        return response()->json(['message' => 'Eventtime deleted successfully']);
    }
}
