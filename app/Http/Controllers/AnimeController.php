<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Genre;
use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimeController extends Controller
{
    // Eloquent: all() + with() untuk eager loading relasi
    public function index()
    {
        $animes = Anime::with(['genre', 'studio'])->latest()->get();
        return view('anime.index', compact('animes'));
    }

    // Kirim data genre & studio ke form
    public function create()
    {
        $genres  = Genre::orderBy('nama')->get();
        $studios = Studio::orderBy('nama')->get();
        return view('anime.create', compact('genres', 'studios'));
    }

    // Eloquent: firstOrCreate() + create()
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'genre_id'    => 'required',
            'studio_id'   => 'required',
            'episode'     => 'required|integer|min:1',
            'rating'      => 'required|numeric|min:0|max:10',
            'sinopsis'    => 'nullable|string',
            'tahun_rilis' => 'nullable|digits:4|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'genre_baru'  => 'nullable|string|max:100',
            'studio_baru' => 'nullable|string|max:100',
        ]);

        $data = $request->except(['gambar', 'genre_baru', 'studio_baru']);

        // Jika user input genre baru
        if ($request->genre_id === 'baru' && $request->genre_baru) {
            $genre = Genre::firstOrCreate(['nama' => $request->genre_baru]);
            $data['genre_id'] = $genre->id;
        }

        // Jika user input studio baru
        if ($request->studio_id === 'baru' && $request->studio_baru) {
            $studio = Studio::firstOrCreate(['nama' => $request->studio_baru]);
            $data['studio_id'] = $studio->id;
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('anime', 'public');
        }

        // Eloquent: create()
        Anime::create($data);

        return redirect()->route('anime.index')->with('success', 'Anime berhasil ditambahkan!');
    }

    // Eloquent: find() via findOrFail() + with() relasi
    public function show($id)
    {
        $anime = Anime::with(['genre', 'studio'])->findOrFail($id);
        return view('anime.show', compact('anime'));
    }

    public function edit($id)
    {
        // Eloquent: find()
        $anime   = Anime::findOrFail($id);
        $genres  = Genre::orderBy('nama')->get();
        $studios = Studio::orderBy('nama')->get();
        return view('anime.edit', compact('anime', 'genres', 'studios'));
    }

    // Eloquent: update()
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'genre_id'    => 'required',
            'studio_id'   => 'required',
            'episode'     => 'required|integer|min:1',
            'rating'      => 'required|numeric|min:0|max:10',
            'sinopsis'    => 'nullable|string',
            'tahun_rilis' => 'nullable|digits:4|integer',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'genre_baru'  => 'nullable|string|max:100',
            'studio_baru' => 'nullable|string|max:100',
        ]);

        $anime = Anime::findOrFail($id);
        $data  = $request->except(['gambar', 'genre_baru', 'studio_baru']);

        if ($request->genre_id === 'baru' && $request->genre_baru) {
            $genre = Genre::firstOrCreate(['nama' => $request->genre_baru]);
            $data['genre_id'] = $genre->id;
        }

        if ($request->studio_id === 'baru' && $request->studio_baru) {
            $studio = Studio::firstOrCreate(['nama' => $request->studio_baru]);
            $data['studio_id'] = $studio->id;
        }

        if ($request->hasFile('gambar')) {
            if ($anime->gambar) {
                Storage::disk('public')->delete($anime->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('anime', 'public');
        }

        // Eloquent: update()
        $anime->update($data);

        return redirect()->route('anime.show', $anime->id)->with('success', 'Anime berhasil diupdate!');
    }

    // Eloquent: delete()
    public function destroy($id)
    {
        $anime = Anime::findOrFail($id);

        if ($anime->gambar) {
            Storage::disk('public')->delete($anime->gambar);
        }

        // Eloquent: delete()
        $anime->delete();

        return redirect()->route('anime.index')->with('success', 'Anime berhasil dihapus!');
    }

    // Eloquent: where() — filter by genre
    public function byGenre($genre_id)
    {
        $genre  = Genre::findOrFail($genre_id);
        $animes = Anime::with(['genre', 'studio'])
                       ->where('genre_id', $genre_id)
                       ->latest()
                       ->get();
        return view('anime.index', compact('animes', 'genre'));
    }
}