<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ArtisTatoController;
use App\Http\Controllers\ArtisKategoriController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LokasiTatoController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\UserKonsultasiController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UserReservasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RuleSpkController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/gallery', [PortfolioController::class, 'gallery'])->name('gallery');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'role:Admin|Pengelola|Pengguna'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('artis_list', [ArtisTatoController::class, 'artis_list'])->name('artis.list');

    Route::resource('konsultasi', UserKonsultasiController::class);
    Route::prefix('reservasi')->name('user.reservasi.')->group(function () {
        Route::get('/', [UserReservasiController::class, 'index'])->name('index');

        // Place specific/static routes before dynamic ones
        Route::get('/{id_konsultasi}/buat', [UserReservasiController::class, 'create'])->name('create');
        Route::get('/payment', [UserReservasiController::class, 'showPayment'])->name('payment');
        Route::get('/{id_reservasi}', [UserReservasiController::class, 'show'])
            ->where('id_reservasi', '[0-9]+')
            ->name('show');

        Route::post('/step1', [UserReservasiController::class, 'storeStep1'])->name('step1.store');
        Route::post('/step2', [UserReservasiController::class, 'storeStep2'])->name('step2.store');
        Route::get('/success', function () {
            return view('user.reservasi.success');
        })->name('success');
    });
    Route::patch('/user/reservasi/{id}/pembayaran', [UserReservasiController::class, 'updatePembayaran'])
        ->name('user.reservasi.pembayaran.update');
    Route::get('/user/reservasi/{id}/invoice', [ReservasiController::class, 'cetakInvoice'])->name('user.reservasi.invoice');
});

Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('kategoris', KategoriController::class);
    Route::resource('artis-kategori', ArtisKategoriController::class);
    Route::resource('artis_tatos', ArtisTatoController::class);
    Route::resource('portfolios', PortfolioController::class)->except(['index', 'show']);
    Route::resource('rules', RuleSpkController::class);
});

Route::middleware(['auth', 'role:Admin|Pengelola'])->group(function () {
    Route::resource('pelanggans', PelangganController::class);
    Route::resource('portfolios', PortfolioController::class)->only(['index', 'show']);
    Route::resource('lokasi_tatos', LokasiTatoController::class);
    Route::resource('konsultasis', KonsultasiController::class);
    Route::resource('reservasis', ReservasiController::class);
    Route::resource('pembayarans', PembayaranController::class);
});


Route::get('/users/search', [UserController::class, 'search'])->name('users.search');



require __DIR__ . '/auth.php';
