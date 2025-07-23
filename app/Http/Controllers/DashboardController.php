<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Konsultasi;
use App\Models\Reservasi;
use App\Models\ArtisTato;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get filter parameters from the request
        $month = $request->input('month', date('m')); // Default to current month
        $year = $request->input('year', date('Y'));   // Default to current year

        // Base queries, now also filtering Pelanggan
        $pelangganQuery = Pelanggan::query();
        $konsultasiQuery = Konsultasi::query();
        $reservasiQuery = Reservasi::query();
        $pembayaranQuery = Reservasi::where('status', 'diterima');

        // Apply monthly filter to all relevant queries
        $pelangganQuery->whereYear('created_at', $year)->whereMonth('created_at', $month); // Filter pelanggan by month
        $konsultasiQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        $reservasiQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);
        $pembayaranQuery->whereYear('created_at', $year)->whereMonth('created_at', $month);


        // Statistik total (semuanya akan difilter bulanan kecuali total artis)
        $totalPelanggan = $pelangganQuery->count(); // Filtered by month
        $totalKonsultasi = $konsultasiQuery->count(); // Filtered by month
        $totalReservasi = $reservasiQuery->count();   // Filtered by month
        $totalPembayaran = $pembayaranQuery->sum('total_pembayaran'); // Filtered by month
        $totalArtis = ArtisTato::count(); // Overall count

        // Statistik konsultasi per bulan (hanya untuk bulan yang dipilih)
        // Data ini sekarang akan hanya berisi satu entri untuk bulan yang dipilih
        $konsultasiPerBulan = Konsultasi::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month) // Added to filter for the selected month only
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Status reservasi (filtered by month)
        $statusReservasi = $reservasiQuery->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->get();

        // 5 reservasi terbaru (filtered by selected month/year)
        $recentReservasi = Reservasi::with('pelanggan', 'konsultasi')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->take(5)
            ->get();

        // Total pembayaran per bulan (showing for the selected year)
        // Ini tetap akan menampilkan data per bulan untuk tahun yang dipilih,
        // karena ini adalah grafik tren tahunan. Jika ingin hanya bulan yang dipilih,
        // logika ini perlu diubah menjadi data tunggal.
        $pembayaranPerBulan = Reservasi::selectRaw('MONTH(created_at) as bulan, SUM(total_pembayaran) as total')
            ->where('status', 'diterima')
            ->whereYear('created_at', $year)
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
                'pembayaranPerBulan',
                'month',
                'year'
            ));
        } elseif (Auth::user()->hasRole('Pengguna')) {
            return view('user.dashboard');
        } else {
            return redirect('/')->with('error', 'Unauthorized access');
        }
    }
}
