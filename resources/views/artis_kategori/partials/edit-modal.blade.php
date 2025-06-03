<div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="editModal = false">
        <h3 class="text-xl font-bold mb-4">Edit Artis Kategori</h3>

        <form method="POST" :action="`{{ url('artis-kategori') }}/` + artisKategori.id_artis_kategori">
            @csrf
            @method('PUT')

            <!-- Select Artis -->
            <div class="mb-4">
                <label class="block mb-1">Artis Tato</label>
                <select name="id_artis_tato" class="w-full border rounded px-3 py-2" x-model="artisKategori.id_artis_tato">
                    <option value="">-- Pilih Artis --</option>
                    @foreach($artis as $a)
                    <option value="{{ $a->id_artis_tato }}">{{ $a->nama_artis_tato }}</option>
                    @endforeach
                </select>
                <template x-if="errors?.id_artis_tato">
                    <p class="text-red-600 text-sm" x-text="errors.id_artis_tato"></p>
                </template>
            </div>

            <!-- Checkbox Kategori -->
            <div class="mb-4">
                <label class="block mb-1">Kategori</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($kategoris as $k)
                    <label class="flex items-center space-x-2">
                        <input
                            type="checkbox"
                            name="id_kategori[]"
                            value="{{ $k->id_kategori }}"
                            :checked="`artisKategori.id_kategori `.includes('{{ $k->id_kategori }}')" x-bind:checked="artisKategori.id_kategori.includes('{{ $k->id_kategori }}')"
                            class="form-checkbox">
                        <span>{{ $k->nama_kategori }}</span>
                    </label>
                    @endforeach
                </div>
                <template x-if="errors?.id_kategori">
                    <p class="text-red-600 text-sm" x-text="errors.id_kategori"></p>
                </template>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" @click="editModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
            </div>
        </form>
    </div>
</div>