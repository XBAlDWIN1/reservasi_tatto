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

    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //check for artis tato
        $artisTato = ArtisTato::find($request->id_artis_tato);
        if (!$artisTato) {
            return redirect()->back()->with(['error' => 'Artis Tato tidak ditemukan!']);
        }

        //validate form
        $request->validate(
            [
                'gambar'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
                'judul'         => 'required|min:5',
                'deskripsi'   => 'required|min:10',
                'id_artis_tato'         => 'required',
            ],
            [
                'gambar.required' => 'Gambar wajib diisi.',
                'gambar.image' => 'Gambar harus berupa file gambar.',
                'gambar.mimes' => 'Gambar harus berupa file jpeg, jpg, atau png.',
                'gambar.max' => 'Ukuran gambar maksimal 2MB.',
                'judul.required' => 'Judul wajib diisi.',
                'judul.min' => 'Judul minimal 5 karakter.',
                'deskripsi.required' => 'Deskripsi wajib diisi.',
                'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
                'id_artis_tato.required' => 'Artis Tato wajib dipilih.',
            ]
        );

        //upload image
        $gambar = $request->file('gambar');
        $gambar->storeAs('/portfolio', $gambar->hashName());

        //create product
        Portfolio::create([
            'gambar'         => $gambar->hashName(),
            'judul'         => $request->judul,
            'deskripsi'   => $request->deskripsi,
            'id_artis_tato'         => $request->id_artis_tato,
        ]);

        //redirect to index
        return redirect()->route('portfolios.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gambar'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'judul'         => 'required|min:5',
            'deskripsi'   => 'required|min:10',
            'id_artis_tato'         => 'required',
        ], [
            'gambar.required' => 'Gambar wajib diisi.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.mimes' => 'Gambar harus berupa file jpeg, jpg, atau png.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'judul.required' => 'Judul wajib diisi.',
            'judul.min' => 'Judul minimal 5 karakter.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'deskripsi.min' => 'Deskripsi minimal 10 karakter.',
            'id_artis_tato.required' => 'Artis Tato wajib dipilih.',
        ]);

        $portfolio = Portfolio::findOrFail($id);

        if ($request->hasFile('gambar')) {
            //upload new image
            $gambar = $request->file('gambar');
            $gambar->storeAs('/portfolio', $gambar->hashName());

            //delete old image
            Storage::delete('/portfolio/' . $portfolio->gambar);

            //update product with new image
            $portfolio->update([
                'gambar'        => $gambar->hashName(),
                'judul'         => $request->judul,
                'deskripsi'     => $request->deskripsi,
                'id_artis_tato' => $request->id_artis_tato,
            ]);
        } else {
            //update product without new image
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

        //delete image
        Storage::delete('/portfolio/' . $portfolio->gambar);

        //delete product
        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portofolio berhasil dihapus.');
    }

    public function gallery()
    {
        $portfolios = Portfolio::latest()->paginate(10);
        return view('gallery', compact('portfolios'));
    }
}
