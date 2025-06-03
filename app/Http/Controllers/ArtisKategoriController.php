<?php

namespace App\Http\Controllers;

use App\Models\ArtisKategori;
use App\Models\ArtisTato;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ArtisKategoriController extends Controller
{
    public function index()
    {
        $artisKategoris = ArtisKategori::with(['artisTato', 'kategori'])->paginate(10);
        $artis = ArtisTato::all();
        $kategoris = Kategori::all();

        return view('artis_kategori.index', compact('artisKategoris', 'artis', 'kategoris'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_artis_tato' => 'required|exists:artis_tatos,id_artis_tato',
            'id_kategori' => 'required|array',
            'id_kategori.*' => 'exists:kategoris,id_kategori',
        ], [
            'id_artis_tato.required' => 'Artis tato wajib diisi.',
            'id_artis_tato.exists' => 'Artis tato tidak ditemukan.',
            'id_kategori.required' => 'Kategori wajib diisi.',
            'id_kategori.array' => 'Kategori harus berupa array.',
            'id_kategori.*.exists' => 'Kategori tidak ditemukan.',
        ]);

        foreach ($validated['id_kategori'] as $kategoriId) {
            // Cek apakah relasi sudah ada
            $exists = ArtisKategori::where('id_artis_tato', $validated['id_artis_tato'])
                ->where('id_kategori', $kategoriId)
                ->exists();

            if (! $exists) {
                ArtisKategori::create([
                    'id_artis_tato' => $validated['id_artis_tato'],
                    'id_kategori' => $kategoriId,
                ]);
            }
        }

        return redirect()->route('artis-kategori.index')->with('success', 'Relasi berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_artis_tato' => 'required|exists:artis_tatos,id_artis_tato',
            'id_kategori' => 'required|array',
            'id_kategori.*' => 'exists:kategoris,id_kategori',
        ], [
            'id_artis_tato.required' => 'Artis tato wajib diisi.',
            'id_artis_tato.exists' => 'Artis tato tidak ditemukan.',
            'id_kategori.required' => 'Kategori wajib diisi.',
            'id_kategori.array' => 'Kategori harus berupa array.',
            'id_kategori.*.exists' => 'Kategori tidak ditemukan.',
        ]);

        // Hapus semua relasi lama untuk artis ini
        ArtisKategori::where('id_artis_tato', $validated['id_artis_tato'])->delete();

        // Tambahkan relasi baru
        foreach ($validated['id_kategori'] as $kategoriId) {
            ArtisKategori::create([
                'id_artis_tato' => $validated['id_artis_tato'],
                'id_kategori' => $kategoriId,
            ]);
        }

        return redirect()->route('artis-kategori.index')->with('success', 'Relasi berhasil diperbarui.');
    }


    public function destroy(ArtisKategori $artisKategori)
    {
        $artisKategori->delete();
        return redirect()->route('artis-kategori.index')->with('success', 'Relasi berhasil dihapus.');
    }
}
