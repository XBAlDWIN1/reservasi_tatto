<div x-show="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-md" @click.away="deleteModal = false">
        <h3 class="text-xl font-bold mb-4">Konfirmasi Hapus</h3>

        <form :action="`{{ url('artis-kategori') }}/` + artisKategoriId" method="POST">
            @csrf
            @method('DELETE')
        
            <p class="mb-4">Apakah Anda yakin ingin menghapus artis kategori ini?</p>
        
            <div class="flex justify-end space-x-2">
                <button type="button" @click="deleteModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
            </div>
        </form>
    </div>
</div>
