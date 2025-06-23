<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RuleSpk;

class RuleSpkController extends Controller
{
    public function index(Request $request)
    {
        $query = RuleSpk::query();

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        $rules = $query->paginate(10);

        return view('rules.index', [
            'rules' => $rules,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:rules_spk,nama',
            'kondisi_if' => 'required|json',
            'hasil_then' => 'required|json',
        ], [
            'nama.required' => 'Nama rules wajib diisi.',
            'nama.unique' => 'Nama rules sudah ada.',
            'nama.max' => 'Nama rules tidak boleh lebih dari 255 karakter.',
            'kondisi_if.required' => 'Kondisi IF wajib diisi.',
            'kondisi_if.json' => 'Kondisi IF harus dalam format JSON.',
            'hasil_then.required' => 'Hasil THEN wajib diisi.',
            'hasil_then.json' => 'Hasil THEN harus dalam format JSON.',
        ]);

        RuleSpk::create($validated);

        return redirect()->back()->with('success', 'Rules berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $rules = RuleSpk::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:rules_spk,nama,' . $rules->id,
            'kondisi_if' => 'required|json',
            'hasil_then' => 'required|json',
        ], [
            'nama.required' => 'Nama rules wajib diisi.',
            'nama.unique' => 'Nama rules sudah ada.',
            'nama.max' => 'Nama rules tidak boleh lebih dari 255 karakter.',
            'kondisi_if.required' => 'Kondisi IF wajib diisi.',
            'kondisi_if.json' => 'Kondisi IF harus dalam format JSON.',
            'hasil_then.required' => 'Hasil THEN wajib diisi.',
            'hasil_then.json' => 'Hasil THEN harus dalam format JSON.',
        ]);

        $rules->update($validated);

        return redirect()->back()->with('success', 'Rules berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rules = RuleSpk::findOrFail($id);
        $rules->delete();

        return redirect()->back()->with('success', 'Rules berhasil dihapus.');
    }
}
