<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inspection;
use App\Models\Child;
use App\Models\Eventtime;


class InspectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil lokasi unik dari tabel eventtime
        $eventtimes = Eventtime::select('lokasi')->distinct()->get();

        // Filter data jika ada request filter
        $inspections = Inspection::query()
            ->with(['child', 'eventtime', 'user'])
            ->when($request->tanggal_pemeriksaan, function ($query) use ($request) {
                $query->whereDate('tanggal_pemeriksaan', $request->tanggal_pemeriksaan);
            })
            ->when($request->lokasi, function ($query) use ($request) {
                $query->whereHas('eventtime', function ($q) use ($request) {
                    $q->where('lokasi', $request->lokasi);
                });
            })
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('child', function ($q) use ($request) {
                    $q->where('nama_anak', 'like', '%' . $request->search . '%');
                });
            })
            ->get();

        return view('dashboard.admin.inspection.index', compact('inspections', 'eventtimes'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Jika menggunakan view untuk form create
        $children = Child::all();
        $eventtimes = Eventtime::all();
        return view('dashboard.admin.inspection.create', compact('children', 'eventtimes'));
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

        return redirect()->route('dashboard.admin.inspection.index')->with('success', 'Data berhasil ditambahkan');
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
        return view('dashboard.admin.inspection.edit', compact('inspection', 'children', 'eventtimes'));
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

        return redirect()->route('dashboard.admin.inspection.index')->with('success', 'Data pemeriksaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inspection $inspection)
    {
        // Hapus data pemeriksaan
        $inspection->delete();

        return redirect()->route('dashboard.admin.inspection.index')->with('success', 'Data pemeriksaan berhasil dihapus');
    }
}
