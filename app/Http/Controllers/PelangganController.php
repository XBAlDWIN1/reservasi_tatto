<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::with('pengguna');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $pelanggans = $query->paginate(10);

        return view('pelanggans.index', [
            'pelanggans' => $pelanggans,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'telepon.max' => 'Nomor telepon tidak valid.',
        ]);

        $validated['id_pengguna'] = Auth::id();

        Pelanggan::create($validated);

        return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'telepon' => ['required', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'telepon.max' => 'Nomor telepon tidak valid.',
        ]);

        $pelanggan->update($validated);

        return redirect()->back()->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus.');
    }
}
