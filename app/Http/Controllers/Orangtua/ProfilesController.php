<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilesController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = Auth::id();
        $children = Child::where('user_id', $userId)->get();
        
        return view('dashboard.orangtua.profiles.index', compact('children'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $child = Child::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        // Get all inspections for this child, ordered by date
        $inspections = Inspection::where('table_child_id', $id)
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();
        
        return view('dashboard.orangtua.profiles.show', compact('child', 'inspections'));
    }
}