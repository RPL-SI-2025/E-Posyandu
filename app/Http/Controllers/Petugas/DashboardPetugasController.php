<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardPetugasController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk Petugas.
     */
    public function index()
    {
        return view('dashboard.petugas.index');
    }
}
