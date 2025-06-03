<?php

namespace App\Http\Controllers;

use App\Models\ArtisTato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtisTatoController extends Controller
{
    public function index(Request $request)
    {
        $query = ArtisTato::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_artis_tato', 'like', "%{$search}%");
            });
        }

        $artis_tatos = $query->paginate(10);

        return view('artis_tatos.index', [
            'artis_tatos' => $artis_tatos,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'nama_artis_tato' => 'required|string|max:255|unique:artis_tatos,nama_artis_tato',
            'tahun_menato' => 'required|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ], [
            'nama_artis_tato.required' => 'Nama artis tato wajib diisi.',
            'nama_artis_tato.unique' => 'Nama artis tato sudah ada.',
            'nama_artis_tato.max' => 'Nama artis tato tidak boleh lebih dari 255 karakter.',
            'tahun_menato.required' => 'Tahun menato wajib diisi.',
            'tahun_menato.max' => 'Tahun menato tidak boleh lebih dari 255 karakter.',
            'instagram.max' => 'Instagram tidak boleh lebih dari 255 karakter.',
            'tiktok.max' => 'TikTok tidak boleh lebih dari 255 karakter.',
            'instagram.string' => 'Instagram harus berupa string.',
            'tiktok.string' => 'TikTok harus berupa string.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.max' => 'Gambar tidak boleh lebih dari 2MB.',
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('artis_tato', 'public');
        }

        ArtisTato::create($data);

        return redirect()->back()->with('success', 'Artis tato berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $artis_tato = ArtisTato::findOrFail($id);

        $request->validate([
            'nama_artis_tato' => 'required|unique:artis_tatos,nama_artis_tato,' . $artis_tato->id_artis_tato . ',id_artis_tato',
            'tahun_menato' => 'required|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|max:2048',
        ], [
            'nama_artis_tato.required' => 'Nama artis tato wajib diisi.',
            'nama_artis_tato.unique' => 'Nama artis tato sudah ada.',
            'nama_artis_tato.max' => 'Nama artis tato tidak boleh lebih dari 255 karakter.',
            'tahun_menato.required' => 'Tahun menato wajib diisi.',
            'tahun_menato.max' => 'Tahun menato tidak boleh lebih dari 255 karakter.',
            'instagram.max' => 'Instagram tidak boleh lebih dari 255 karakter.',
            'tiktok.max' => 'TikTok tidak boleh lebih dari 255 karakter.',
            'instagram.string' => 'Instagram harus berupa string.',
            'tiktok.string' => 'TikTok harus berupa string.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.max' => 'Gambar tidak boleh lebih dari 2MB.',
        ]);

        $data = $request->except('gambar'); // Semua data kecuali gambar

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($artis_tato->gambar && Storage::disk('public')->exists($artis_tato->gambar)) {
                Storage::disk('public')->delete($artis_tato->gambar);
            }

            // Simpan gambar baru
            $data['gambar'] = $request->file('gambar')->store('artis_tato', 'public');
        } else {
            $data['gambar'] = $artis_tato->gambar; // Tetap gunakan gambar lama
        }
        $artis_tato->update($data);

        return redirect()->back()->with('success', 'Artis tato berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $artis_tato = ArtisTato::findOrFail($id);

        //delete image
        Storage::disk('public')->delete($artis_tato->gambar);

        //delete product
        $artis_tato->delete();

        return redirect()->back()->with('success', 'Portofolio berhasil dihapus.');
    }

    public function artis_list(Request $request)
    {
        $query = ArtisTato::query()->with('artisKategoris.kategori'); // Load kategori lewat relasi

        $kategori = $request->query('kategori');

        if ($kategori) {
            // Filter artis yang menguasai kategori tertentu
            $query->whereHas('artisKategoris', function ($q) use ($kategori) {
                $q->where('id_kategori', $kategori);
            });
        }

        if ($search = $request->query('search')) {
            $query->where('nama_artis_tato', 'like', "%{$search}%");
        }

        $artis_tatos = $query->paginate(10);

        return view('artis_list', [
            'artis_tatos' => $artis_tatos,
            'kategori' => $kategori,
        ]);
    }
}
