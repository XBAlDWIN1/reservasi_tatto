<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LokasiTato;

class LokasiTatoController extends Controller
{
    public function index(Request $request)
    {
        $query = LokasiTato::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lokasi_tato', 'like', "%{$search}%");
            });
        }

        $lokasi_tatos = $query->paginate(10);

        return view('lokasi_tatos.index', [
            'lokasi_tatos' => $lokasi_tatos,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lokasi_tato' => 'required|string|max:255|unique:lokasi_tatos,nama_lokasi_tato',
        ], [
            'nama_lokasi_tato.required' => 'Nama lokasi tato wajib diisi.',
            'nama_lokasi_tato.unique' => 'Nama lokasi tato sudah ada.',
            'nama_lokasi_tato.max' => 'Nama lokasi tato tidak boleh lebih dari 255 karakter.',
        ]);

        LokasiTato::create($validated);

        return redirect()->back()->with('success', 'Lokasi tato berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $lokasi_tato = LokasiTato::findOrFail($id);

        $validated = $request->validate([
            'nama_lokasi_tato' => 'required|unique:lokasi_tatos,nama_lokasi_tato,' . $lokasi_tato->id_lokasi_tato . ',id_lokasi_tato',
            'nama_lokasi_tato' => 'max:255',
        ], [
            'nama_lokasi_tato.required' => 'Nama lokasi tato wajib diisi.',
            'nama_lokasi_tato.unique' => 'Nama lokasi tato sudah ada.',
            'nama_lokasi_tato.max' => 'Nama lokasi tato tidak boleh lebih dari 255 karakter.',
        ]);

        $lokasi_tato->update($validated);

        return redirect()->back()->with('success', 'Lokasi tato berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $lokasi_tato = LokasiTato::findOrFail($id);
        $lokasi_tato->delete();

        return redirect()->back()->with('success', 'Lokasi tato berhasil dihapus.');
    }
}
