<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Carbon\Carbon; 

class ProfilesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::id();
        $children = Child::where('user_id', auth()->id())->get();
        
        return view('dashboard.orangtua.profiles.index', compact('children'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $child = Child::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
            $inspections = Inspection::where('table_child_id', $id)
            ->select(
                'id', 
                'tanggal_pemeriksaan', 
                DB::raw('CAST(berat_badan AS DECIMAL(5,2)) as berat_badan'),
                DB::raw('CAST(tinggi_badan AS DECIMAL(5,2)) as tinggi_badan'),
                // 'lingkar_kepala',
                // 'status_gizi',
                // 'catatan'
            )
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();
        
            // Format dates and ensure numeric values for charts
            foreach ($inspections as $inspection) {
                $inspection->formatted_date = Carbon::parse($inspection->tanggal_pemeriksaan)->format('d-m-Y');
                
                // Ensure weight and height are numeric values
                $inspection->berat_badan = (float)$inspection->berat_badan;
                $inspection->tinggi_badan = (float)$inspection->tinggi_badan;
            }
            
            // Debug information
            // dd($inspections->toArray());
        
        return view('dashboard.orangtua.profiles.show', compact('child', 'inspections'));
    }

    // create e child
    public function create()
    {
        return view('dashboard.orangtua.profiles.create');
    }

    // store child
    public function store(Request $request)
    {
        $userId = Auth::id();
        $validated = $request->validate([
            'nama_anak' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => 'nullable|string|max:255|unique:table_child,nik',
        ]);

        $validated['user_id'] = $userId;

        $child = Child::create($validated);

        return redirect()->route('dashboard.orangtua.profiles.index')->with('success', 'Anak berhasil ditambahkan.');
    }

    // edit baliita
    public function edit($id)
    {
        $userId = Auth::id();
        $child = Child::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        return view('dashboard.orangtua.profiles.edit', compact('child'));
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $child = Child::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
            
        $validated = $request->validate([
            'nama_anak' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'nik' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('table_child', 'nik')->ignore($child->id),
            ],
        ]);
        
        $child->update($validated);
        
        return redirect()->route('dashboard.orangtua.profiles.index')
            ->with('success', 'Data anak berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $child = Child::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        $child->delete();
        
        return redirect()->route('dashboard.orangtua.profiles.index')
            ->with('success', 'Data anak berhasil dihapus.');
    }
}