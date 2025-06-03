<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;

class UserReservasiController extends Controller
{
    public function index()
    {
        $reservasi = Reservasi::where('id_pengguna', Auth::id())->paginate(5);

        $pelanggan = Pelanggan::where('id_pengguna', Auth::id())->get();
        $konsultasi = Konsultasi::where('id_pengguna', Auth::id())->get();
        $pembayaran = Pembayaran::where('id_pengguna', Auth::id())->get();
        return view('user.reservasi.index', compact('reservasi', 'pelanggan', 'konsultasi', 'pembayaran'));
    }

    public function show($id)
    {
        $reservasi = Reservasi::with(['pelanggan', 'konsultasi'])->findOrFail($id);
        return view('user.reservasi.show', compact('reservasi'));
    }

    private function getTotalBiaya($panjang, $lebar, $kategori)
    {
        $luas = $panjang * $lebar;
        $harga_per_cm2 = 15000;
        $minimal = 800000;

        if (str_contains(strtolower($kategori), 'mesin')) {
            $harga_per_cm2 = 15000;
            $minimal = 800000;
        } elseif (str_contains(strtolower($kategori), 'handpoke') || str_contains(strtolower($kategori), 'hand tap')) {
            $harga_per_cm2 = 16000;
            $minimal = 900000;
        }

        return max($luas * $harga_per_cm2, $minimal);
    }

    public function create($id_konsultasi)
    {
        $konsultasi = Konsultasi::findOrFail($id_konsultasi);
        $panjang = $konsultasi->panjang ?? 0;
        $lebar = $konsultasi->lebar ?? 0;
        $kategori = $konsultasi->kategori->nama_kategori ?? '';
        $total_biaya = $this->getTotalBiaya($panjang, $lebar, $kategori);

        // Ambil pelanggan milik user
        $pelangganList = Pelanggan::where('id_pengguna', Auth::id())->get();

        return view('user.reservasi.create', compact('konsultasi', 'total_biaya', 'pelangganList'));
    }


    public function storeStep1(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required_without:pelanggan_lama|nullable|string|max:255',
            'telepon' => 'required_with:nama_lengkap|required_without:pelanggan_lama|nullable|string|max:20',
            'pelanggan_lama' => 'nullable|exists:pelanggans,id_pelanggan',
            'id_konsultasi' => 'required|exists:konsultasis,id_konsultasi',
        ], [
            'nama_lengkap.required_without' => 'Nama lengkap wajib diisi jika tidak memilih pelanggan lama.',
            'telepon.required_without' => 'Telepon wajib diisi jika tidak memilih pelanggan lama.',
            'telepon.required_with' => 'Telepon wajib diisi jika mengisi nama lengkap.',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        $id_konsultasi = $request->id_konsultasi;
        $konsultasi = Konsultasi::findOrFail($id_konsultasi);

        if ($request->filled('pelanggan_lama')) {
            // Gunakan pelanggan lama
            $id_pelanggan = $request->pelanggan_lama;
        } else {
            // Buat pelanggan baru
            $pelanggan = Pelanggan::create([
                'id_pengguna' => $user->id,
                'nama_lengkap' => $request->nama_lengkap,
                'telepon' => $request->telepon,
            ]);
            $id_pelanggan = $pelanggan->id_pelanggan;
        }

        $total_biaya = $this->getTotalBiaya(
            $konsultasi->panjang ?? 0,
            $konsultasi->lebar ?? 0,
            $konsultasi->kategori->nama_kategori ?? ''
        );

        $reservasi = Reservasi::create([
            'id_pengguna' => $user->id,
            'id_pelanggan' => $id_pelanggan,
            'id_konsultasi' => $id_konsultasi,
            'status' => 'menunggu',
            'total_pembayaran' => $total_biaya,
        ]);

        session([
            'id_reservasi' => $reservasi->id_reservasi,
            'id_konsultasi' => $id_konsultasi,
        ]);

        // dd(session('id_reservasi'), session('id_konsultasi'));

        return redirect()->route('user.reservasi.payment');
    }
    public function showPayment()
    {
        // Hapus dd di produksi
        $id_reservasi = session('id_reservasi');
        $id_konsultasi = session('id_konsultasi');

        if (!$id_konsultasi || !$id_reservasi) {
            return redirect()
                ->route('user.reservasi.create', ['id_konsultasi' => $id_konsultasi])
                ->withErrors('Session expired. Silakan ulangi proses.');
        }

        $konsultasi = Konsultasi::findOrFail($id_konsultasi);
        $panjang = $konsultasi->panjang ?? 0;
        $lebar = $konsultasi->lebar ?? 0;
        $kategori = optional($konsultasi->kategori)->nama_kategori ?? '';

        $total_biaya = $this->getTotalBiaya($panjang, $lebar, $kategori);

        $reservasi = Reservasi::findOrFail($id_reservasi);

        return view('user.reservasi.pay', compact('reservasi', 'total_biaya', 'konsultasi'));
    }


    public function storeStep2(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'bukti_pembayaran.required' => 'Bukti pembayaran wajib diisi.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa file dengan format jpeg, png, jpg.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 2MB.',
        ]);

        $id_reservasi = session('id_reservasi');
        $id_pengguna = Auth::id();
        if (!$id_pengguna) {
            return redirect()->route('login')->withErrors('Silakan login terlebih dahulu.');
        }

        if (!$id_reservasi) {
            return redirect()->route('user.reservasi.create')->withErrors('Session expired. Silakan ulangi proses.');
        }

        $bukti = $request->file('bukti_pembayaran');
        $bukti->storeAs('/bukti_pembayaran', $bukti->hashName(), 'public');

        Pembayaran::create([
            'id_reservasi' => $id_reservasi,
            'id_pengguna' => $id_pengguna,
            'status' => 'menunggu',
            'bukti_pembayaran' => $bukti->hashName(),
            'catatan' => $request->catatan,
        ]);

        session()->forget(['konsultasi_id', 'pelanggan_id', 'reservasi_id']);

        return redirect()->route('user.reservasi.success')->with('success', 'Reservasi berhasil dibuat. Silakan tunggu konfirmasi dari admin.');
    }
}
