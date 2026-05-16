<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimeController extends Controller
{
    // Tampilkan semua data anime
    public function index()
    {
        $animes = Anime::all();
        return view('anime.index', compact('animes'));
    }

    // Form tambah anime
    public function create()
    {
        return view('anime.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'genre'       => 'required|string|max:100',
            'episode'     => 'required|integer|min:1',
            'rating'      => 'required|numeric|min:0|max:10',
            'sinopsis'    => 'nullable|string',
            'studio'      => 'nullable|string|max:100',
            'tahun_rilis' => 'nullable|digits:4|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->except('gambar');

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('anime', 'public');
        }

        Anime::create($data);
        return redirect()->route('anime.index')->with('success', 'Anime berhasil ditambahkan!');
    }

    // Detail 1 anime
    public function show($id)
    {
        $anime = Anime::findOrFail($id);
        return view('anime.show', compact('anime'));
    }

    // Form edit
    public function edit($id)
    {
        $anime = Anime::findOrFail($id);
        return view('anime.edit', compact('anime'));
    }

    // Simpan perubahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'genre'       => 'required|string|max:100',
            'episode'     => 'required|integer|min:1',
            'rating'      => 'required|numeric|min:0|max:10',
            'sinopsis'    => 'nullable|string',
            'studio'      => 'nullable|string|max:100',
            'tahun_rilis' => 'nullable|digits:4|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $anime = Anime::findOrFail($id);
        $data = $request->except('gambar');

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($anime->gambar) {
                Storage::disk('public')->delete($anime->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('anime', 'public');
        }

        $anime->update($data);
        return redirect()->route('anime.show', $anime->id)->with('success', 'Anime berhasil diupdate!');
    }

    // Hapus data
    public function destroy($id)
    {
        $anime = Anime::findOrFail($id);

        // Hapus gambar dari storage
        if ($anime->gambar) {
            Storage::disk('public')->delete($anime->gambar);
        }

        $anime->delete();
        return redirect()->route('anime.index')->with('success', 'Anime berhasil dihapus!');
    }
}