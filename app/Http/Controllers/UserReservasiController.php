<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use App\Helpers\HargaHelper;
use Illuminate\Support\Facades\Storage;

class UserReservasiController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $reservasi = Reservasi::with([
            'konsultasi.kategori',
            'pelanggan',
            'pembayaran' => function ($q) {
                $q->latest(); // Ambil pembayaran terbaru jika ada lebih dari satu
            }
        ])
            ->where('id_pengguna', $userId)
            ->orderByDesc('created_at')
            ->paginate(5);

        // Hitung total biaya untuk setiap reservasi
        foreach ($reservasi as $item) {
            $konsultasi = $item->konsultasi;

            $biayaDasar = HargaHelper::hitungHargaDasar(
                $konsultasi->panjang ?? 0,
                $konsultasi->lebar ?? 0,
                optional($konsultasi->kategori)->nama_kategori ?? ''
            );
            $biayaTambahan = $konsultasi->biaya_tambahan ?? 0;
            $totalBiaya = $biayaDasar + $biayaTambahan;

            $item->biaya_dasar = $biayaDasar;
            $item->biaya_tambahan = $biayaTambahan;
            $item->total_biaya = $totalBiaya;
        }

        return view('user.reservasi.index', compact('reservasi'));
    }

    public function show($id)
    {
        $reservasi = Reservasi::with([
            'pelanggan',
            'konsultasi.kategori',
            'pembayaran' => function ($query) {
                $query->latest();
            }
        ])->findOrFail($id);

        // Hitung biaya
        $konsultasi = $reservasi->konsultasi;

        $biayaDasar = HargaHelper::hitungHargaDasar(
            $konsultasi->panjang ?? 0,
            $konsultasi->lebar ?? 0,
            optional($konsultasi->kategori)->nama_kategori ?? ''
        );
        $biayaTambahan = $konsultasi->biaya_tambahan ?? 0;
        $totalBiaya = $biayaDasar + $biayaTambahan;

        $reservasi->biaya_dasar = $biayaDasar;
        $reservasi->biaya_tambahan = $biayaTambahan;
        $reservasi->total_biaya = $totalBiaya;

        return view('user.reservasi.show', compact('reservasi'));
    }

    public function updatePembayaran(Request $request, $id)
    {
        $reservasi = Reservasi::with('pembayaran')
            ->where('id_reservasi', $id)
            ->where('id_pengguna', Auth::id())
            ->firstOrFail();

        if (!$reservasi->pembayaran || $reservasi->pembayaran->status !== 'ditolak') {
            return redirect()->back()->with('error', 'Pembayaran hanya bisa diperbarui jika statusnya ditolak.');
        }

        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $request->file('bukti_pembayaran');
        $filename = $file->hashName(); // Gunakan hashName seperti admin
        $file->storeAs('bukti_pembayaran', $filename, 'public');

        // Hapus bukti lama jika ada
        if ($reservasi->pembayaran->bukti_pembayaran) {
            Storage::disk('public')->delete('bukti_pembayaran/' . $reservasi->pembayaran->bukti_pembayaran);
        }

        // Update pembayaran
        $reservasi->pembayaran->update([
            'bukti_pembayaran' => $filename,
            'status' => 'menunggu',
            'catatan_penolakan' => null,
        ]);

        return redirect()->route('user.reservasi.show', $id)->with('success', 'Bukti pembayaran berhasil diperbarui dan menunggu verifikasi.');
    }

    public function create($id_konsultasi)
    {
        $konsultasi = Konsultasi::findOrFail($id_konsultasi);
        $panjang = $konsultasi->panjang ?? 0;
        $lebar = $konsultasi->lebar ?? 0;
        $kategori = $konsultasi->kategori->nama_kategori ?? '';
        $biaya_dasar = HargaHelper::hitungHargaDasar($panjang, $lebar, $kategori);
        $biaya_tambahan = $konsultasi->biaya_tambahan ?? 0;
        $total_biaya = $biaya_dasar + $biaya_tambahan;

        // Ambil pelanggan milik user
        $pelangganList = Pelanggan::where('id_pengguna', Auth::id())->get();

        return view('user.reservasi.create', compact('konsultasi', 'total_biaya', 'biaya_dasar', 'biaya_tambahan', 'pelangganList'));
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

        $biaya_dasar = HargaHelper::hitungHargaDasar(
            $konsultasi->panjang ?? 0,
            $konsultasi->lebar ?? 0,
            optional($konsultasi->kategori)->nama_kategori ?? ''
        );

        $biaya_tambahan = $konsultasi->biaya_tambahan ?? 0;
        $total_biaya = $biaya_dasar + $biaya_tambahan;

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

        $biaya_dasar = HargaHelper::hitungHargaDasar($panjang, $lebar, $kategori);
        $biaya_tambahan = $konsultasi->biaya_tambahan ?? 0;
        $total_biaya = $biaya_dasar + $biaya_tambahan;

        $reservasi = Reservasi::findOrFail($id_reservasi);

        return view('user.reservasi.pay', compact('reservasi', 'total_biaya', 'biaya_dasar', 'biaya_tambahan', 'konsultasi'));
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
