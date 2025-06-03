<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $query = Kategori::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', "%{$search}%");
            });
        }

        $kategoris = $query->paginate(10);

        return view('kategoris.index', [
            'kategoris' => $kategoris,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi' => 'nullable|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'deskripsi.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa string.',
        ]);

        Kategori::create($validated);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,' . $kategori->id_kategori . ',id_kategori',
            'nama_kategori' => 'max:255',
            'deskripsi' => 'nullable|string|max:255',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah ada.',
            'nama_kategori.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'deskripsi.max' => 'Deskripsi tidak boleh lebih dari 255 karakter.',
            'deskripsi.string' => 'Deskripsi harus berupa string.',
        ]);

        $kategori->update($validated);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
