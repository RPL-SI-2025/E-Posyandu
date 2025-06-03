<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Eventtime;
use App\Models\Artikel;
use Carbon\Carbon;

class DashboardOrangtuaController extends Controller
{
    /**
     * Tampilkan halaman dashboard untuk orangtua.
     */
    public function index()
    {
        $userId = Auth::id();

        // Get children for the logged-in user
        $children = Child::where('user_id', $userId)->get();
        $childrenCount = $children->count();

        // Enhance children data with their latest inspection details
        $childrenData = $children->map(function ($child) {
            $latestInspection = Inspection::where('table_child_id', $child->id)
                                          ->orderBy('tanggal_pemeriksaan', 'desc')
                                          ->first();
            $child->latest_berat_badan = $latestInspection ? $latestInspection->berat_badan : null;
            $child->latest_tinggi_badan = $latestInspection ? $latestInspection->tinggi_badan : null;
            return $child;
        });

        // Get the latest upcoming Posyandu schedule
        // Assuming 'tanggal' is the field for the event date in Eventtime model
        $latestEvent = Eventtime::where('tanggal', '>=', Carbon::today())
                                ->orderBy('tanggal', 'asc')
                                ->first();

        $articles = Artikel::where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

            return view('dashboard.orangtua.index', compact('childrenCount', 'childrenData', 'latestEvent', 'articles'));
    }

    /**
     * Tampilkan halaman berita untuk orangtua.
     */
    public function berita()
    {
        // You can fetch the news articles here and pass them to the view
        $articles = Artikel::where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->select('id_artikel', 'judul', 'created_at', 'isi', 'gambar')
            ->get();

        return view('dashboard.orangtua.berita.index', compact('articles'));
    }

    /**
     * Tampilkan halaman detail berita untuk orangtua.
     */
    public function showBerita($id)
    {
         // You can fetch the news articles here and pass them to the view
        $articles = Artikel::where('is_show', 1)
            ->orderBy('created_at', 'desc')
            ->select('id_artikel', 'judul', 'created_at', 'isi')
            ->get();

        $article = Artikel::findOrFail($id);
        return view('dashboard.orangtua.berita.show', compact('article'));
    }
}
