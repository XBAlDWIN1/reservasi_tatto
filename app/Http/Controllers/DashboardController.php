<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Konsultasi;
use App\Models\Reservasi;
use App\Models\ArtisTato;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Statistik total
        $totalPelanggan = Pelanggan::count();
        $totalKonsultasi = Konsultasi::count();
        $totalReservasi = Reservasi::count();
        $totalPembayaran = Reservasi::where('status', 'diterima')->sum('total_pembayaran');
        $totalArtis = ArtisTato::count();

        // Statistik konsultasi per bulan
        $konsultasiPerBulan = Konsultasi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Status reservasi
        $statusReservasi = Reservasi::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // 5 reservasi terbaru
        $recentReservasi = Reservasi::with('pelanggan', 'konsultasi')
            ->latest()
            ->take(5)
            ->get();

        // Total pembayaran per bulan
        $pembayaranPerBulan = Reservasi::selectRaw('MONTH(created_at) as bulan, SUM(total_pembayaran) as total')
            ->where('status', 'diterima')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // return view berdasarkan role
        if (Auth::user()->hasAnyRole(['Admin', 'Pengelola'])) {
            return view('dashboard', compact(
                'totalPelanggan',
                'totalKonsultasi',
                'totalReservasi',
                'totalPembayaran',
                'totalArtis',
                'konsultasiPerBulan',
                'statusReservasi',
                'recentReservasi',
                'pembayaranPerBulan'
            ));
        } elseif (Auth::user()->hasRole('Pengguna')) {
            return view('user.dashboard');
        } else {
            return redirect('/')->with('error', 'Unauthorized access');
        }
    }
}
