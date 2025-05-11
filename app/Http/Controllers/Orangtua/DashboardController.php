<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk orangtua.
     */
    public function index()
    {
        return view('dashboard.orangtua.index');
    }
}
