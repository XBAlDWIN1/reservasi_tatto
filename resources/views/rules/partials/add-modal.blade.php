<div x-show="addModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="addModal = false" x-data="{ 
        sampleIf: { lokasi_tato: 'lengan', ukuran_tato: 'besar' }, 
        sampleThen: { hasil: 'diterima' },
        formatJson(field) {
            try {
                const textarea = $refs[field];
                const parsed = JSON.parse(textarea.value);
                textarea.value = JSON.stringify(parsed, null, 2);
            } catch (e) {
                alert('Format JSON tidak valid!');
            }
        }
    }">
        <h3 class="text-xl font-bold mb-4">Tambah Rules</h3>

        <form method="POST" action="{{ route('rules.store') }}">
            @csrf

            <!-- Nama -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Nama Rules</label>
                <input type="text" name="nama" value="{{ old('nama') }}" class="w-full border rounded px-3 py-2">
                @error('nama') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Kondisi IF -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <label class="block mb-1 font-medium">Kondisi IF (JSON)</label>
                    <div class="space-x-2 text-sm">
                        <button type="button" class="text-blue-600 hover:underline"
                            @click="$refs.kondisi_if.value = JSON.stringify(sampleIf, null, 2)">
                            Contoh
                        </button>
                        <button type="button" class="text-green-600 hover:underline"
                            @click="formatJson('kondisi_if')">
                            Format
                        </button>
                    </div>
                </div>
                <textarea x-ref="kondisi_if" name="kondisi_if" rows="4" class="w-full font-mono border rounded px-3 py-2">{{ old('kondisi_if') }}</textarea>
                @error('kondisi_if') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Hasil THEN -->
            <div class="mb-4">
                <div class="flex items-center justify-between">
                    <label class="block mb-1 font-medium">Hasil THEN (JSON)</label>
                    <div class="space-x-2 text-sm">
                        <button type="button" class="text-blue-600 hover:underline"
                            @click="$refs.hasil_then.value = JSON.stringify(sampleThen, null, 2)">
                            Contoh
                        </button>
                        <button type="button" class="text-green-600 hover:underline"
                            @click="formatJson('hasil_then')">
                            Format
                        </button>
                    </div>
                </div>
                <textarea x-ref="hasil_then" name="hasil_then" rows="4" class="w-full font-mono border rounded px-3 py-2">{{ old('hasil_then') }}</textarea>
                @error('hasil_then') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" @click="addModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
            </div>
        </form>
    </div>
</div>