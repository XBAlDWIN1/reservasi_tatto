<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konsultasi;
use Illuminate\Support\Facades\Auth;
use App\Models\LokasiTato;
use App\Models\Kategori;
use App\Models\ArtisTato;
use App\Models\Portfolio;
use App\Models\RuleSpk;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Carbon\CarbonInterval;
use App\Helpers\HargaHelper;

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

            // Hitung biaya dasar
            $biayaDasar = HargaHelper::hitungHargaDasar(
                $konsultasi->panjang ?? 0,
                $konsultasi->lebar ?? 0,
                optional($konsultasi->kategori)->nama_kategori ?? ''
            );

            // Ambil biaya tambahan
            $biayaTambahan = $konsultasi->biaya_tambahan ?? 0;

            // Total biaya = dasar + tambahan
            $total = $biayaDasar + $biayaTambahan;

            // Tambahkan atribut virtual ke model
            $konsultasi->biaya_dasar = $biayaDasar;
            $konsultasi->biaya_tambahan = $biayaTambahan;
            $konsultasi->total_biaya = $total;
        }

        return view('user.konsultasi.index', compact('konsultasis'));
    }

    public function create()
    {
        $lokasi_tatos = LokasiTato::all();
        $kategoris = Kategori::all();
        $portfolios = Portfolio::all();

        return view('user.konsultasi.create', compact('lokasi_tatos', 'portfolios', 'kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required',
            'id_lokasi_tato' => 'required|exists:lokasi_tatos,id_lokasi_tato',
            'id_kategori' => 'required',
            'panjang' => 'required|numeric',
            'lebar' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_galeri' => 'nullable|string',
            'jadwal_tanggal' => 'required|date|after_or_equal:today',
            'jadwal_jam' => ['required', 'date_format:H:i', function ($attribute, $value, $fail) {
                if ($value < '09:00' || $value > '17:00') {
                    $fail('Waktu harus antara 09:00 dan 17:00.');
                }
            }],
            'warna' => 'required|in:Warna,Satu Warna',
            'jenis_desain' => 'required|string'
        ]);

        // Validasi tambahan: pastikan salah satu gambar tersedia
        if (!$request->hasFile('gambar') && !$request->gambar_galeri) {
            return redirect()->back()->withErrors(['gambar' => 'Gambar harus diunggah atau dipilih dari galeri.'])->withInput();
        }

        $panjang = $request->panjang;
        $lebar = $request->lebar;
        $luas = $panjang * $lebar;

        if ($luas < 50) {
            $ukuran = 'kecil';
        } elseif ($luas <= 70) {
            $ukuran = 'sedang';
        } else {
            $ukuran = 'besar';
        }

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

        $data = $request->except(['jadwal_jam', 'gambar', 'gambar_galeri']);
        $data['jadwal_konsultasi'] = $request->jadwal_tanggal . ' ' . $request->jadwal_jam;

        if (isset($facts['kategori_kompleksitas'])) {
            $data['kompleksitas'] = $facts['kategori_kompleksitas'];
        }

        if (isset($facts['durasi_estimasi'])) {
            try {
                preg_match('/\d+/', $facts['durasi_estimasi'], $matches);
                $jam = isset($matches[0]) ? (int) $matches[0] : 0;
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

            $data['id_artis_tato'] = $artis->id_artis_tato ?? null;
        }

        if (!isset($data['id_artis_tato'])) {
            $defaultArtis = ArtisTato::orderBy('tahun_menato', 'asc')->first();
            if (!$defaultArtis) {
                return redirect()->back()->withErrors([
                    'id_artis_tato' => 'Tidak ada artis tato tersedia saat ini.'
                ])->withInput();
            }
            $data['id_artis_tato'] = $defaultArtis->id_artis_tato;
        }

        $mulai = Carbon::parse($data['jadwal_konsultasi']);
        $selesai = (clone $mulai)->add(CarbonInterval::createFromFormat('H:i', $data['durasi_estimasi']));

        $bentrok = Konsultasi::where('id_artis_tato', $data['id_artis_tato'])
            ->whereDate('jadwal_konsultasi', $mulai->toDateString())
            ->get()
            ->filter(function ($konsultasi) use ($mulai, $selesai) {
                $existingMulai = Carbon::parse($konsultasi->jadwal_konsultasi);
                $existingSelesai = (clone $existingMulai)->add(CarbonInterval::createFromFormat('H:i', $konsultasi->durasi_estimasi ?? '03:00'));
                return $mulai < $existingSelesai && $selesai > $existingMulai;
            });

        if ($bentrok->isNotEmpty()) {
            return redirect()->back()->withErrors([
                'jadwal_konsultasi' => 'Jadwal reservasi sudah penuh pada waktu tersebut. Silakan pilih waktu lain.'
            ])->withInput();
        }

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('konsultasi', 'public');
        } elseif ($request->gambar_galeri) {
            // Ambil path dari URL asset galeri
            $path = str_replace(asset('storage') . '/', '', $request->gambar_galeri);
            $data['gambar'] = $path;
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
