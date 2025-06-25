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
use Illuminate\Support\Facades\Log;
use Carbon\CarbonInterval;

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

    public function create()
    {
        $lokasi_tatos = LokasiTato::all();
        $kategoris = Kategori::all();

        return view('user.konsultasi.create', compact('lokasi_tatos', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required',
            'id_lokasi_tato' => 'required|exists:lokasi_tatos,id_lokasi_tato',
            'id_kategori' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'jadwal_tanggal' => 'required|date|after_or_equal:today',
            'jadwal_jam' => 'required|date_format:H:i',
            'warna' => 'required|in:Warna,Satu Warna',
            'jenis_desain' => 'required|string'
        ]);

        $panjang = $request->panjang;
        $lebar = $request->lebar;
        $luas = $panjang * $lebar;

        if ($luas < 50) {
            $ukuran = 'kecil';
        } elseif ($luas <= 99) {
            $ukuran = 'sedang';
        } else {
            $ukuran = 'besar';
        }

        // Ambil nama lokasi dari ID
        $lokasi = LokasiTato::find($request->id_lokasi_tato);

        $facts = [
            'desain' => strtolower($request->jenis_desain),
            'ukuran' => $ukuran,
            'lokasi_tubuh' => strtolower(optional($lokasi)->nama_lokasi_tato ?? ''),
            'permintaan_khusus' => strtolower($request->warna),
        ];

        $rules = RuleSpk::all()->map(function ($rule) {
            return [
                'nama' => $rule->nama,
                'if' => is_string($rule->kondisi_if) ? json_decode($rule->kondisi_if, true) ?? [] : $rule->kondisi_if,
                'then' => is_string($rule->hasil_then) ? json_decode($rule->hasil_then, true) ?? [] : $rule->hasil_then,
            ];
        })->toArray();

        $applied = [];
        do {
            $changed = false;
            foreach ($rules as $rule) {
                $match = collect($rule['if'])->every(fn($v, $k) => isset($facts[$k]) && strtolower($facts[$k]) == strtolower($v));
                if ($match && !in_array($rule['nama'], $applied)) {
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

        if (isset($facts['kategori_kompleksitas'])) {
            $data['kompleksitas'] = $facts['kategori_kompleksitas'];
        }

        if (isset($facts['durasi_estimasi'])) {
            try {
                // Ambil angka dari string "8 jam"
                preg_match('/\d+/', $facts['durasi_estimasi'], $matches);
                $jam = isset($matches[0]) ? (int) $matches[0] : 0;

                // Buat durasi dari jam ke format H:i
                $durasi = Carbon::createFromTime(0, 0)->addHours($jam);
                $data['durasi_estimasi'] = $durasi->format('H:i');
            } catch (\Exception $e) {
                Log::error('Gagal parsing durasi_estimasi: ' . $e->getMessage());
                $data['durasi_estimasi'] = '03:00';
            }
        }

        if (isset($facts['biaya_tambahan'])) {
            $data['biaya_tambahan'] = $facts['biaya_tambahan'];
        }

        $data['kompleksitas'] = $data['kompleksitas'] ?? 'sedang';
        $data['durasi_estimasi'] = $data['durasi_estimasi'] ?? '03:00';
        $data['biaya_tambahan'] = $data['biaya_tambahan'] ?? 0;

        if (isset($facts['artist_rekomendasi'])) {
            $kategori = strtolower($facts['artist_rekomendasi']);
            $tahunIni = Carbon::now()->year;

            $artis = ArtisTato::all()->filter(function ($a) use ($tahunIni, $kategori) {
                if ($kategori === 'senior') {
                    return ($tahunIni - $a->tahun_menato) >= 5;
                } elseif ($kategori === 'junior') {
                    return ($tahunIni - $a->tahun_menato) < 5;
                }
                return false;
            })->sortBy('tahun_menato')->first();

            $data['id_artis_tato'] = $artis->id_artis_tato ?? ArtisTato::where('tahun_menato', '<', $tahunIni)->min('id_artis_tato');
        }

        $mulai = Carbon::parse($data['jadwal_konsultasi']);
        $selesai = (clone $mulai)->add(CarbonInterval::createFromFormat('H:i', $data['durasi_estimasi']));

        // Cek bentrok dengan jadwal artis lain
        $bentrok = Konsultasi::where('id_artis_tato', $data['id_artis_tato'])
            ->whereDate('jadwal_konsultasi', $mulai->toDateString())
            ->get()
            ->filter(function ($konsultasi) use ($mulai, $selesai) {
                $existingMulai = Carbon::parse($konsultasi->jadwal_konsultasi);
                $existingSelesai = (clone $existingMulai)->add(CarbonInterval::createFromFormat('H:i', $konsultasi->durasi_estimasi ?? '03:00'));

                // Cek jika waktu overlap
                return $mulai < $existingSelesai && $selesai > $existingMulai;
            });

        if ($bentrok->isNotEmpty()) {
            return redirect()->back()->withErrors([
                'jadwal_konsultasi' => 'Jadwal reservasi sudah penuh pada waktu tersebut. Silakan pilih waktu lain.'
            ])->withInput();
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konsultasi', 'public');
        }


        Konsultasi::create($data);

        if ($request->user()->hasRole('Pengguna')) {
            return redirect()->route('konsultasi.index')->with('success', 'Konsultasi berhasil dibuat.');
        } elseif ($request->user()->hasRole('Admin')) {
            return redirect()->route('konsultasis.index')->with('success', 'Data Konsultasi berhasil ditambahkan.');
        }
        return redirect()->back()->with('success', 'Data Konsultasi berhasil ditambahkan.');
    }
}
