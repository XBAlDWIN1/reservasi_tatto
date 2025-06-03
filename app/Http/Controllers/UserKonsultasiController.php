<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiTato;
use App\Models\Kategori;
use App\Models\ArtisKategori;

class UserKonsultasiController extends Controller
{
    // Get konsultasi by currently logged in user
    public function index(Request $request)
    {
        $userId = Auth::id();

        $konsultasis = Konsultasi::with('reservasi')->where('id_pengguna', $userId)
            ->with('artisTato', 'lokasiTato', 'kategori')
            ->paginate(10);

        // Tambahkan total_biaya ke setiap item
        foreach ($konsultasis as $konsultasi) {
            $panjang = $konsultasi->panjang ?? 0;
            $lebar = $konsultasi->lebar ?? 0;
            $namaKategori = strtolower($konsultasi->kategori->nama_kategori ?? '');

            $luas = $panjang * $lebar;

            if (str_contains($namaKategori, 'mesin')) {
                $harga_per_cm2 = 15000;
                $minimal = 800000;
            } elseif (str_contains($namaKategori, 'handpoke') || str_contains($namaKategori, 'hand tap')) {
                $harga_per_cm2 = 16000;
                $minimal = 900000;
            } else {
                $harga_per_cm2 = 15000;
                $minimal = 800000;
            }

            $total = $luas * $harga_per_cm2;
            $total = max($total, $minimal);

            // Tambahkan atribut virtual
            $konsultasi->total_biaya = $total;
        }

        return view('user.konsultasi.index', compact('konsultasis'));
    }

    public function create(Request $request)
    {
        $id_artis_tato = $request->query('id_artis_tato');
        $nama_artis_tato = $request->query('nama_artis_tato');
        $lokasi_tatos = LokasiTato::all();

        // Ambil id_kategori dari artis_kategoris
        $kategoriIds = ArtisKategori::where('id_artis_tato', $id_artis_tato)->pluck('id_kategori');

        // Ambil data kategori berdasarkan id tersebut
        $kategoris = Kategori::whereIn('id_kategori', $kategoriIds)->get();

        return view('user.konsultasi.create', compact('id_artis_tato', 'nama_artis_tato', 'lokasi_tatos', 'kategoris'));
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
}
