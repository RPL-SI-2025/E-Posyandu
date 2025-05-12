<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::all();
        return view('dashboard.admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        return view('dashboard.admin.artikel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('artikel', 'public');
        }

        Artikel::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'gambar' => $imagePath,
            'author' => 'Admin',
            'is_show' => $request->has('is_show') ? 1 : 0,
        ]);

        return redirect()->route('dashboard.admin.artikel.index')->with('success', 'Artikel berhasil disimpan');
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('dashboard.admin.artikel.show', compact('artikel'));
    }

    public function edit($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('dashboard.admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required',
        ]);

        $artikel = Artikel::findOrFail($id);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('artikel', 'public');
            $artikel->gambar = $imagePath;
        }
        $artikel->judul = $request->judul;
        $artikel->isi = $request->isi;
        $artikel->is_show = $request->has('is_show') ? 1 : 0;
        $artikel->save();

        return redirect()->route('dashboard.admin.artikel.index')->with('success', 'Artikel berhasil diperbarui');
    }

    public function destroy($id)
    {
        $artikel = Artikel::findOrFail($id);
        $artikel->delete();

        return redirect()->route('dashboard.admin.artikel.index')->with('success', 'Artikel berhasil dihapus');
    }
}
