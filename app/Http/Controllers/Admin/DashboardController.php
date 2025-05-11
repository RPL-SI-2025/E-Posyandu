<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk admin.
     */
    public function index()
    {
        return view('dashboard.admin.index'); // Mengarahkan ke view dashboard admin
    }
}