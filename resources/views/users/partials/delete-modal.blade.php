<div x-show="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
    <div class="bg-white rounded-lg p-6 w-full max-w-sm" @click.away="deleteModal = false">
        <h3 class="text-lg font-semibold mb-4">Hapus User</h3>
        <p>Apakah Anda yakin ingin menghapus user ini?</p>

        <form method="POST" :action="'/users/' + userId" class="mt-4">
            @csrf
            @method('DELETE')

            <div class="flex justify-end space-x-2">
                <button type="button" @click="deleteModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
            </div>
        </form>
    </div>
</div>
