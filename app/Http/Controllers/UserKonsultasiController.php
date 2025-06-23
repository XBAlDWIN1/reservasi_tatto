<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiTato;
use App\Models\Kategori;
use App\Models\ArtisTato;
use App\Models\RuleSpk;
use Carbon\Carbon;

class UserKonsultasiController extends Controller
{
    // Get konsultasi by currently logged in user
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Ambil semua konsultasi milik user, dengan relasi terkait
        $konsultasis = Konsultasi::with(['reservasi', 'artisTato', 'lokasiTato', 'kategori'])
            ->where('id_pengguna', $userId)
            ->paginate(10);

        foreach ($konsultasis as $konsultasi) {
            $panjang = $konsultasi->panjang ?? 0;
            $lebar = $konsultasi->lebar ?? 0;
            $luas = $panjang * $lebar;

            $kategoriNama = strtolower(optional($konsultasi->kategori)->nama_kategori ?? '');

            // Tentukan harga berdasarkan kategori
            if (str_contains($kategoriNama, 'mesin')) {
                $hargaPerCm = 15000;
                $hargaMinimal = 800000;
            } elseif (str_contains($kategoriNama, 'handpoke') || str_contains($kategoriNama, 'hand tap')) {
                $hargaPerCm = 16000;
                $hargaMinimal = 900000;
            } else {
                $hargaPerCm = 15000;
                $hargaMinimal = 800000;
            }

            $total = max($luas * $hargaPerCm, $hargaMinimal);

            // Tambahkan biaya tambahan jika ada
            if (!empty($konsultasi->biaya_tambahan)) {
                $total += $konsultasi->biaya_tambahan;
            }

            // Tambahkan atribut virtual ke model
            $konsultasi->total_biaya = $total;
        }

        return view('user.konsultasi.index', compact('konsultasis'));
    }


    // public function create(Request $request)
    // {
    //     $id_artis_tato = $request->query('id_artis_tato');
    //     $nama_artis_tato = $request->query('nama_artis_tato');
    //     $lokasi_tatos = LokasiTato::all();

    //     // Ambil id_kategori dari artis_kategoris
    //     $kategoriIds = ArtisKategori::where('id_artis_tato', $id_artis_tato)->pluck('id_kategori');

    //     // Ambil data kategori berdasarkan id tersebut
    //     $kategoris = Kategori::whereIn('id_kategori', $kategoriIds)->get();

    //     return view('user.konsultasi.create', compact('id_artis_tato', 'nama_artis_tato', 'lokasi_tatos', 'kategoris'));
    // }
    public function create()
    {
        $lokasi_tatos = LokasiTato::all();
        $kategoris = Kategori::all();

        return view('user.konsultasi.create', compact('lokasi_tatos', 'kategoris'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id_pengguna' => 'required',
            'id_lokasi_tato' => 'required',
            'id_kategori' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jadwal_tanggal' => 'required|date|after_or_equal:today',
            'jadwal_jam' => 'required|date_format:H:i',
            'warna' => 'required|in:Warna,Satu Warna',
        ]);

        $panjang = $request->panjang;
        $lebar = $request->lebar;
        if ($panjang * $lebar < 50) {
            $ukuran = 'kecil';
        } elseif ($panjang * $lebar <= 99) {
            $ukuran = 'sedang';
        } else {
            $ukuran = 'besar';
        }

        $facts = [
            'desain' => strtolower($request->jenis_desain),
            'ukuran' => $ukuran,
            'lokasi_tubuh' => strtolower(optional($request->lokasi_tato)->nama_lokasi_tato ?? ''),
            'permintaan_khusus' => strtolower($request->warna),
        ];

        // Ambil semua rule dan ubah jadi array asosiatif
        $rules = RuleSpk::all()->map(function ($rule) {
            return [
                'nama' => $rule->nama,
                'if' => is_string($rule->kondisi_if) ? json_decode($rule->kondisi_if, true) : $rule->kondisi_if,
                'then' => is_string($rule->hasil_then) ? json_decode($rule->hasil_then, true) : $rule->hasil_then,

            ];
        })->toArray();

        $applied = [];
        do {
            $changed = false;
            foreach ($rules as $rule) {
                // Cek apakah semua kondisi IF match dengan facts
                $match = collect($rule['if'])->every(fn($v, $k) => isset($facts[$k]) && $facts[$k] == strtolower($v));

                if ($match && !in_array($rule['nama'], $applied)) {
                    // Tambahkan hasil THEN ke facts
                    foreach ($rule['then'] as $k => $v) {
                        $facts[$k] = $v;
                    }
                    $applied[] = $rule['nama'];
                    $changed = true;
                }
            }
        } while ($changed);

        $data = $request->except(['jadwal_jam', 'gambar']);
        $data['jadwal_konsultasi'] = $request->jadwal_tanggal . ' ' . $request->jadwal_jam;

        // Terapkan hasil dari facts jika ada
        if (isset($facts['kategori_kompleksitas'])) {
            $data['kompleksitas'] = $facts['kategori_kompleksitas'];
        }

        if (isset($facts['durasi_estimasi'])) {
            $jam = explode(' ', $facts['durasi_estimasi'])[0];
            $data['durasi_estimasi'] = Carbon::createFromTimeString($jam)->format('H:i');
        }

        if (isset($facts['biaya_tambahan'])) {
            $data['biaya_tambahan'] = $facts['biaya_tambahan'];
        }

        $data['kompleksitas'] = $data['kompleksitas'] ?? 'sedang';
        $data['durasi_estimasi'] = $data['durasi_estimasi'] ?? '03:00';
        $data['biaya_tambahan'] = $data['biaya_tambahan'] ?? 0;

        // Rekomendasi artis
        if (isset($facts['artist_rekomendasi'])) {
            $kategori = strtolower($facts['artist_rekomendasi']);
            $tahunIni = Carbon::now()->year;

            if ($kategori === 'senior') {
                $artis = ArtisTato::all()->filter(function ($a) use ($tahunIni) {
                    return ($tahunIni - $a->tahun_menato) >= 5;
                })->sortBy('tahun_menato')->first();
            } elseif ($kategori === 'junior') {
                $artis = ArtisTato::all()->filter(function ($a) use ($tahunIni) {
                    return ($tahunIni - $a->tahun_menato) < 5;
                })->sortByDesc('tahun_menato')->first();
            } else {
                $artis = null;
            }

            if ($artis) {
                $data['id_artis_tato'] = $artis->id_artis_tato;
            }
        }

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konsultasi', 'public');
        }

        Konsultasi::create($data);

        // Redirect
        if ($request->user()->hasRole('Pengguna')) {
            return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dibuat.');
        } elseif ($request->user()->hasRole('Admin')) {
            return redirect()->route('konsultasis.index')->with('success', 'Data Konsultasi berhasil ditambahkan.');
        }
        return redirect()->back()->with('success', 'Data Konsultasi berhasil ditambahkan.');
    }
}
