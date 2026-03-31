<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $bukus = Buku::with('kategori')->latest()->paginate(5);
        return view('petugas.buku.index', compact('bukus'));
    }

    // FORM TAMBAH
public function create()
{
    $kategori = Kategori::all(); // singular biar rapi
    return view('petugas.buku.create', compact('kategori'));
}

    // SIMPAN DATA
public function store(Request $request)
{
    $request->validate([
        'judul' => 'required',
        'penulis' => 'required',
        'penerbit' => 'required',
        'tahun_terbit' => 'required',
        'stok' => 'required|integer',
        'kategori_id' => 'required',
        'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $gambar = null;

    if ($request->hasFile('gambar')) {
        $gambar = $request->file('gambar')->store('buku', 'public');
    }

    Buku::create([
        'judul' => $request->judul,
        'penulis' => $request->penulis,
        'penerbit' => $request->penerbit,
        'tahun_terbit' => $request->tahun_terbit,
        'stok' => $request->stok,
        'status' => $request->status,
        'kategori_id' => $request->kategori_id,
        'gambar' => $gambar,

        // 🔥 INI YANG WAJIB DITAMBAH
        'bahasa' => $request->bahasa,
        'jumlah_halaman' => $request->jumlah_halaman,
        'sinopsis' => $request->sinopsis,
    ]);

    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan');
}

    // FORM EDIT
    public function edit(string $id)
    {
        $buku = Buku::findOrFail($id);
        $kategori = Kategori::all();

        return view('petugas.buku.edit', compact('buku', 'kategoris'));
    }

    // UPDATE
    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required',
            'stok' => 'required|integer',
            'kategori_id' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // cek gambar baru
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')->store('buku', 'public');
        } else {
            $gambar = $buku->gambar;
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'penerbit' => $request->penerbit,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
            'gambar' => $gambar
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate');
    }

    // DELETE
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus');
    }


}
