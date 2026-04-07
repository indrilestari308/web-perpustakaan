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
        $buku = Buku::with('kategori')->latest()->paginate(5);
        return view('petugas.buku.index', compact('buku'));
    }

    public function detail($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('anggota.detail', compact('buku'));
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

        return view('petugas.buku.edit', compact('buku', 'kategori'));
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

    public function indexAnggota(Request $request)
    {
        $query = Buku::with('kategori')->latest();
    
        if ($request->filled('cari')) {
            $query->where(function($q) use ($request) {
                $q->where('judul', 'like', '%'.$request->cari.'%')
                  ->orWhere('penulis', 'like', '%'.$request->cari.'%');
            });
        }
    
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }
    
        $buku = $query->paginate(12);
        $kategoriList = \App\Models\Kategori::all();
    
        return view('anggota.buku', compact('buku', 'kategoriList'));
    }
    
  public function pinjam($id)
{
    $buku = Buku::findOrFail($id);

    if ($buku->stok <= 0) {
        return redirect()->back()->with('error', 'Stok buku habis.');
    }

    // 🔥 CEK biar ga double
    $sudahPinjam = \App\Models\Peminjaman::where('user_id', auth()->id())
        ->where('buku_id', $id)
        ->whereIn('status', ['menunggu', 'dipinjam'])
        ->exists();

    if ($sudahPinjam) {
        return redirect()->back()->with('error', 'Kamu sudah mengajukan atau meminjam buku ini.');
    }

    \App\Models\Peminjaman::create([
        'user_id'         => auth()->id(),
        'buku_id'         => $id,
        'tanggal_pinjam'  => now(),
        'tanggal_kembali' => now()->addDays(7),
        'status'          => 'menunggu', // 🔥 INI YANG PENTING
        'denda'           => 0,
    ]);

   

    return redirect()->back()->with('success', 'Permintaan peminjaman dikirim, tunggu konfirmasi petugas.');
}
}
