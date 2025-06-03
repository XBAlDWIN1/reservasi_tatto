<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\User;
use App\Models\ArtisTato;
use App\Models\LokasiTato;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use App\Models\ArtisKategori;

class KonsultasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Konsultasi::with('pengguna', 'artisTato', 'lokasiTato', 'kategori');
        $pengguna = User::all();
        $artisTatos = ArtisTato::all();
        $lokasiTatos = LokasiTato::all();
        $kategoris = Kategori::all();
        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal_konsultasi', 'like', "%{$search}%")
                    ->orWhereHas('pengguna', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }
        $konsultasis = $query->paginate(10);
        return view('konsultasis.index', [
            'konsultasis' => $konsultasis,
            'pengguna' => $pengguna,
            'artisTatos' => $artisTatos,
            'lokasiTatos' => $lokasiTatos,
            'kategoris' => $kategoris,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id_pengguna' => 'required',
            'id_artis_tato' => 'required',
            'id_lokasi_tato' => 'required',
            'id_kategori' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jadwal_tanggal' => 'required|date|after_or_equal:today',
            'jadwal_jam' => 'required|date_format:H:i',
            'status' => 'nullable|in:menunggu,diterima,ditolak',
        ], [
            'id_pengguna.required' => 'Pengguna wajib diisi.',
            'id_artis_tato.required' => 'Artis tato wajib diisi.',
            'id_lokasi_tato.required' => 'Lokasi tato wajib diisi.',
            'id_kategori.required' => 'Kategori wajib diisi.',
            'panjang.required' => 'Panjang wajib diisi.',
            'panjang.numeric' => 'Panjang harus berupa angka.',
            'lebar.required' => 'Lebar wajib diisi.',
            'lebar.numeric' => 'Lebar harus berupa angka.',
            'jadwal_tanggal.required' => 'Tanggal wajib diisi.',
            'jadwal_tanggal.date' => 'Tanggal tidak valid.',
            'jadwal_jam.required' => 'Jam wajib diisi.',
            'jadwal_jam.date_format' => 'Jam tidak valid. Format harus HH:MM.',
            'jadwal_tanggal.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
            'gambar.required' => 'Gambar wajib diisi.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.max' => 'Gambar tidak boleh lebih dari 2MB.',
            'status.in' => 'Status tidak valid.',
        ]);

        $jadwalKonsultasi = $request->jadwal_tanggal . ' ' . $request->jadwal_jam;

        $request->merge(['jadwal_konsultasi' => $jadwalKonsultasi]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konsultasi', 'public');
        }

        Konsultasi::create($data);
        // redirect berdasarkan role
        if ($request->user()->hasRole('Pengguna')) {
            return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dibuat.');
        } elseif ($request->user()->hasRole('Admin')) {
            return redirect()->route('konsultasis.index')->with('success', 'Data Konsultasi berhasil ditambahkan.');
        }
        // Jika tidak ada role yang sesuai, redirect ke halaman sebelumnya
        return redirect()->back()->with('success', 'Data Konsultasi berhasil ditambahkan.');
    }

    public function update(Request $request, Konsultasi $konsultasi)
    {
        // dd($request->all());
        $request->validate([
            'id_pengguna' => 'required',
            'id_artis_tato' => 'required',
            'id_lokasi_tato' => 'required',
            'id_kategori' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'jadwal_tanggal' => 'required|date',
            'jadwal_jam' => 'required|date_format:H:i',
            'gambar' => 'nullable|image|max:2048',
            'status' => 'nullable|in:menunggu,diterima,ditolak',
        ], [
            'id_pengguna.required' => 'Pengguna wajib diisi.',
            'id_artis_tato.required' => 'Artis tato wajib diisi.',
            'id_lokasi_tato.required' => 'Lokasi tato wajib diisi.',
            'id_kategori.required' => 'Kategori wajib diisi.',
            'panjang.required' => 'Panjang wajib diisi.',
            'panjang.numeric' => 'Panjang harus berupa angka.',
            'lebar.required' => 'Lebar wajib diisi.',
            'lebar.numeric' => 'Lebar harus berupa angka.',
            'jadwal_tanggal.required' => 'Tanggal wajib diisi.',
            'jadwal_tanggal.date' => 'Tanggal tidak valid.',
            'jadwal_jam.required' => 'Jam wajib diisi.',
            'jadwal_jam.date_format' => 'Jam tidak valid. Format harus HH:MM.',
            'gambar.image' => 'Gambar harus berupa file gambar.',
            'gambar.max' => 'Gambar tidak boleh lebih dari 2MB.',
            'status.in' => 'Status tidak valid.',
        ]);


        $jadwalKonsultasi = $request->input('jadwal_tanggal') . ' ' . $request->input('jadwal_jam');
        $request->merge(['jadwal_konsultasi' => $jadwalKonsultasi]);

        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($konsultasi->gambar && Storage::disk('public')->exists($konsultasi->gambar)) {
                Storage::disk('public')->delete($konsultasi->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('konsultasi', 'public');
        } else {
            $data['gambar'] = $konsultasi->gambar;
        }

        $konsultasi->update($data);

        return redirect()->route('konsultasis.index')->with('success', 'Data Konsultasi berhasil diupdate.');
    }

    public function destroy($id)
    {
        $konsultasi = Konsultasi::findOrFail($id);

        if ($konsultasi->reservasi) {
            return redirect()->back()->with('error', 'Konsultasi tidak dapat dihapus karena sudah memiliki data reservasi.');
        }

        //delete image
        if ($konsultasi->gambar && Storage::disk('public')->exists($konsultasi->gambar)) {
            Storage::disk('public')->delete($konsultasi->gambar);
        }

        //delete data
        $konsultasi->delete();

        return redirect()->route('konsultasis.index')->with('success', 'Data Konsultasi berhasil dihapus.');
    }
}
