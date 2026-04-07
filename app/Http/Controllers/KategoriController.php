<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    // TAMPIL DATA
    public function index()
    {
        $kategoris = Kategori::withCount('buku')->latest()->get();
        return view('petugas.kategori.index', compact('kategoris'));
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                function ($attribute, $value, $fail) {
                    $exists = DB::table('kategori')
                        ->whereRaw('LOWER(nama_kategori) = ?', [strtolower($value)])
                        ->exists();

                    if ($exists) {
                        $fail('Nama kategori sudah ada');
                    }
                }
            ]
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);
        

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    //UPDATE

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                function ($attribute, $value, $fail) use ($kategori) {
                    $exists = DB::table('kategoris')
                        ->whereRaw('LOWER(nama_kategori) = ?', [strtolower($value)])
                        ->where('id', '!=', $kategori->id)
                        ->exists();

                    if ($exists) {
                        $fail('Nama kategori sudah ada.');
                    }
                }
            ]
        ]);

        Kategori::findOrFail($id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    // HAPUS
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus');
    }
}
