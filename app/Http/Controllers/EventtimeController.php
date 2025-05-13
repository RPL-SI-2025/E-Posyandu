<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Eventtime;

class EventtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan semua data eventtime
        $eventtimes = Eventtime::all();
        //return response()->json($eventtimes);
        return view('dashboard.admin.event.index', compact('eventtimes'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika menggunakan view untuk form create
        return view('dashboard.admin.event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Eventtime::create($validated);

        return redirect()->route('dashboard.admin.event.index')
            ->with('success', 'Jadwal kegiatan berhasil ditambahkan.');
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
        return view('dashboard.admin.event.edit', compact('eventtime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Eventtime $eventtime)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $eventtime->update($validated);

        return redirect()->route('dashboard.admin.event.index')
            ->with('success', 'Jadwal kegiatan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eventtime $eventtime)
    {
        $eventtime->delete();

        return redirect()->route('dashboard.admin.event.index')
            ->with('success', 'Jadwal kegiatan berhasil dihapus.');
    }

}
