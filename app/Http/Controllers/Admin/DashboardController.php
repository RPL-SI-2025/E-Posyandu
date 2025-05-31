<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Balita;
use App\Models\Inspection;
use App\Models\Eventtime;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk admin.
     */
    public function index()
    {
        // Hitung akun yang masih menunggu verifikasi
        $jumlahMenungguVerifikasi = User::where('verifikasi', 'waiting')->count();

        // Hitung akun yang disetujui dan ditolak (jika perlu)
        $jumlahDisetujui = User::where('verifikasi', 'approved')->count();
        $jumlahDitolak = User::where('verifikasi', 'rejected')->count();

        // Ambil data perkembangan bayi (misalnya ambil 10 terakhir)
        $perkembanganBayi = Inspection::with('child')
            ->latest('tanggal_pemeriksaan')
            ->take(10)
            ->get();
        
        $acaraMendatang = Eventtime::whereDate('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        return view('dashboard.admin.index', compact(
            'jumlahMenungguVerifikasi',
            'jumlahDisetujui',
            'jumlahDitolak',
            'perkembanganBayi',
            'acaraMendatang'
        ));
    }
}