<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;
use App\Models\ArtisTato;
use Illuminate\Http\RedirectResponse;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::latest()->paginate(10);
        $artisTatos = ArtisTato::all();

        return view('portfolios.index', compact('portfolios', 'artisTatos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $artisTato = ArtisTato::find($request->id_artis_tato);
        if (!$artisTato) {
            return redirect()->back()->with(['error' => 'Artis Tato tidak ditemukan!']);
        }

        $request->validate(
            [
                'gambar'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
                'judul'          => 'required|min:5',
                'deskripsi'      => 'required|min:10',
                'id_artis_tato'  => 'required',
            ],
            [
                'gambar.required'     => 'Gambar wajib diisi.',
                'gambar.image'        => 'Gambar harus berupa file gambar.',
                'gambar.mimes'        => 'Gambar harus berupa file jpeg, jpg, atau png.',
                'gambar.max'          => 'Ukuran gambar maksimal 2MB.',
                'judul.required'      => 'Judul wajib diisi.',
                'judul.min'           => 'Judul minimal 5 karakter.',
                'deskripsi.required'  => 'Deskripsi wajib diisi.',
                'deskripsi.min'       => 'Deskripsi minimal 10 karakter.',
                'id_artis_tato.required' => 'Artis Tato wajib dipilih.',
            ]
        );

        $gambar = $request->file('gambar');
        $filename = $gambar->hashName();
        $path = $gambar->storeAs('portfolio', $filename);

        $relativePath = 'portfolio/' . $filename;

        Portfolio::create([
            'gambar'         => $relativePath,
            'judul'          => $request->judul,
            'deskripsi'      => $request->deskripsi,
            'id_artis_tato'  => $request->id_artis_tato,
        ]);

        return redirect()->route('portfolios.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'judul'          => 'required|min:5',
            'deskripsi'      => 'required|min:10',
            'id_artis_tato'  => 'required',
        ], [
            'gambar.required'     => 'Gambar wajib diisi.',
            'gambar.image'        => 'Gambar harus berupa file gambar.',
            'gambar.mimes'        => 'Gambar harus berupa file jpeg, jpg, atau png.',
            'gambar.max'          => 'Ukuran gambar maksimal 2MB.',
            'judul.required'      => 'Judul wajib diisi.',
            'judul.min'           => 'Judul minimal 5 karakter.',
            'deskripsi.required'  => 'Deskripsi wajib diisi.',
            'deskripsi.min'       => 'Deskripsi minimal 10 karakter.',
            'id_artis_tato.required' => 'Artis Tato wajib dipilih.',
        ]);

        $portfolio = Portfolio::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $filename = $gambar->hashName();
            $path = $gambar->storeAs('portfolio', $filename);
            $relativePath = 'portfolio/' . $filename;

            // Hapus gambar lama
            if (Storage::exists($portfolio->gambar)) {
                Storage::delete($portfolio->gambar);
            }

            $portfolio->update([
                'gambar'        => $relativePath,
                'judul'         => $request->judul,
                'deskripsi'     => $request->deskripsi,
                'id_artis_tato' => $request->id_artis_tato,
            ]);
        } else {
            $portfolio->update([
                'judul'         => $request->judul,
                'deskripsi'     => $request->deskripsi,
                'id_artis_tato' => $request->id_artis_tato,
            ]);
        }

        return redirect()->route('portfolios.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::findOrFail($id);

        // Hapus gambar jika ada
        if (Storage::exists($portfolio->gambar)) {
            Storage::delete($portfolio->gambar);
        }

        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portofolio berhasil dihapus.');
    }

    public function gallery()
    {
        $portfolios = Portfolio::with('artisTato')->latest()->paginate(10);
        return view('gallery', compact('portfolios'));
    }
}
