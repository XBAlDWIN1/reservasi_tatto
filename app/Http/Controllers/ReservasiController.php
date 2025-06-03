<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\Konsultasi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['pengguna', 'pelanggan', 'konsultasi']);

        if ($search = $request->query('search')) {
            $query->whereHas('pelanggan', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            })->orWhereHas('pengguna', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $reservasis = $query->paginate(10);
        $penggunas = User::all();
        $pelanggans = Pelanggan::all();
        $konsultasis = Konsultasi::all();

        return view('reservasis.index', compact('reservasis', 'penggunas', 'pelanggans', 'konsultasis'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_pengguna' => 'required|exists:users,id',
            'id_pelanggan' => 'required|exists:pelanggans,id_pelanggan',
            'id_konsultasi' => 'required|exists:konsultasis,id_konsultasi',
            'status' => 'nullable|in:menunggu,diterima,ditolak',
        ], [
            'id_pengguna.required' => 'Pengguna wajib diisi.',
            'id_pengguna.exists' => 'Pengguna tidak ditemukan.',
            'id_pelanggan.required' => 'Pelanggan wajib diisi.',
            'id_pelanggan.exists' => 'Pelanggan tidak ditemukan.',
            'id_konsultasi.required' => 'Konsultasi wajib diisi.',
            'id_konsultasi.exists' => 'Konsultasi tidak ditemukan.',
            'status.in' => 'Status tidak valid.',
        ]);

        $konsultasi = Konsultasi::with('kategori')->findOrFail($request->id_konsultasi);

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

        Reservasi::create([
            'id_pengguna' => $request->id_pengguna,
            'id_pelanggan' => $request->id_pelanggan,
            'id_konsultasi' => $request->id_konsultasi,
            'total_pembayaran' => $total,
            'status' => $request->status ?? 'menunggu',
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil dibuat.');
    }

    public function cetakInvoice($id)
    {
        $reservasi = Reservasi::with(['pelanggan', 'konsultasi.kategori', 'konsultasi.lokasiTato', 'konsultasi.artisTato'])
            ->findOrFail($id);

        $pdf = Pdf::loadView('user.reservasi.invoice', compact('reservasi'));
        return $pdf->stream('kwitansi-reservasi.pdf'); // Bisa juga ->download() untuk langsung mengunduh
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        $request->validate([
            'id_konsultasi' => 'required|exists:konsultasis,id_konsultasi',
            'total_pembayaran' => 'required|numeric|min:0',
            'status' => 'nullable|in:menunggu,diterima,ditolak',
        ], [
            'id_konsultasi.required' => 'Konsultasi wajib diisi.',
            'id_konsultasi.exists' => 'Konsultasi tidak ditemukan.',
            'total_pembayaran.required' => 'Total pembayaran wajib diisi.',
            'total_pembayaran.numeric' => 'Total pembayaran harus berupa angka.',
            'total_pembayaran.min' => 'Total pembayaran tidak valid.',
            'status.in' => 'Status tidak valid.',
        ]);

        $reservasi->update([
            'id_konsultasi' => $request->id_konsultasi,
            'total_pembayaran' => $request->total_pembayaran,
            'status' => $request->status ?? $reservasi->status,
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::findOrFail($id);

        if ($reservasi->konsultasi) {
            return redirect()->back()->with('error', 'Reservasi tidak dapat dihapus karena masih terhubung dengan data konsultasi.');
        }

        $reservasi->delete();

        return redirect()->back()->with('success', 'Reservasi berhasil dihapus.');
    }
}
