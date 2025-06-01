<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Balita;
use App\Models\Inspection;
use App\Models\Eventtime;
use Carbon\Carbon;

class DashboardPetugasController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk admin.
     */
    public function index()
    {
        $jumlahMenungguVerifikasi = User::where('role', 'orangtua')
            ->where('verifikasi', 'waiting')
            ->count();

        $jumlahDisetujui = User::where('role', 'orangtua')
            ->where('verifikasi', 'approved')
            ->count();

        $jumlahDitolak = User::where('role', 'orangtua')
            ->where('verifikasi', 'rejected')
            ->count();

        // Ambil data perkembangan bayi (misalnya ambil 10 terakhir)
        $perkembanganBayi = Inspection::with('child')
            ->latest('tanggal_pemeriksaan')
            ->take(10)
            ->get();
        
        $acaraMendatang = Eventtime::whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        return view('dashboard.petugas.index', compact(
            'jumlahMenungguVerifikasi',
            'jumlahDisetujui',
            'jumlahDitolak',
            'perkembanganBayi',
            'acaraMendatang'
        ));
    }
}