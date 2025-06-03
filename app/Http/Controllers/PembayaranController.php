<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\User; // Mungkin diperlukan jika ada relasi dengan user
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Jika menangani upload file

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with(['reservasi']);

        if ($search = $request->query('search')) {
            $query->whereHas('reservasi', function ($q) use ($search) {
                $q->where('id_reservasi', 'like', "%{$search}%"); // Contoh pencarian berdasarkan ID Reservasi
            })->orWhere('status', 'like', "%{$search}%"); // Contoh pencarian berdasarkan status
        }

        $pembayarans = $query->paginate(10);
        $reservasis = Reservasi::all(); // Untuk dropdown form
        $penggunas = User::all(); // Jika ada relasi dengan user, untuk dropdown form

        return view('pembayarans.index', compact('pembayarans', 'reservasis', 'penggunas'));
    }

    public function create()
    {
        $reservasis = Reservasi::all();
        $penggunas = User::all(); // Jika ada relasi dengan user
        return view('pembayarans.create', compact('reservasis', 'penggunas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_reservasi' => 'required|exists:reservasis,id_reservasi',
            'id_pengguna' => 'nullable|exists:users,id', // Contoh jika ada relasi dengan user yang membuat pembayaran
            'status' => 'required|in:menunggu,diterima,ditolak',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan' => 'nullable|string|max:255',
        ], [
            'id_reservasi.required' => 'Reservasi wajib diisi.',
            'id_reservasi.exists' => 'Reservasi tidak ditemukan.',
            'status.required' => 'Status wajib diisi.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa file jpeg, png, jpg, atau gif.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 2MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_pembayaran')) {
            $bukti = $request->file('bukti_pembayaran');
            $bukti->storeAs('/bukti_pembayaran', $bukti->hashName(), 'public');
            $data['bukti_pembayaran'] = $bukti->hashName();
        }

        Pembayaran::create($data);

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        return view('pembayarans.show', compact('pembayaran'));
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $reservasis = Reservasi::all();
        $penggunas = User::all(); // Jika ada relasi dengan user
        return view('pembayarans.edit', compact('pembayaran', 'reservasis', 'penggunas'));
    }

    public function update(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        $request->validate([
            'id_reservasi' => 'required|exists:reservasis,id_reservasi',
            'id_pengguna' => 'nullable|exists:users,id', // Contoh jika ada relasi dengan user yang membuat pembayaran
            'status' => 'required|in:menunggu,diterima,ditolak',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'catatan' => 'nullable|string|max:255',
        ], [
            'id_reservasi.required' => 'Reservasi wajib diisi.',
            'id_reservasi.exists' => 'Reservasi tidak ditemukan.',
            'status.required' => 'Status wajib diisi.',
            'bukti_pembayaran.image' => 'Bukti pembayaran harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus berupa file jpeg, png, jpg, atau gif.',
            'bukti_pembayaran.max' => 'Ukuran bukti pembayaran maksimal 2MB.',
        ]);

        $data = $request->all();

        if ($request->hasFile('bukti_pembayaran')) {
            // Hapus bukti pembayaran lama jika ada
            if ($pembayaran->bukti_pembayaran) {
                Storage::delete('/bukti_pembayaran/' . $pembayaran->bukti_pembayaran);
            }
            $bukti = $request->file('bukti_pembayaran');
            $bukti->storeAs('/bukti_pembayaran', $bukti->hashName(), 'public');

            $data['bukti_pembayaran'] = $bukti->hashName();
        }

        $pembayaran->update($data);

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        // Hapus bukti pembayaran jika ada
        if ($pembayaran->bukti_pembayaran) {
            Storage::delete('/bukti_pembayaran/' . $pembayaran->bukti_pembayaran);
        }

        $pembayaran->delete();

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
