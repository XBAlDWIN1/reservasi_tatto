<div x-show="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md">
        <h3 class="text-lg font-semibold mb-4 text-center">Hapus Portfolio</h3>
        <p class="text-center text-gray-700 mb-6">Apakah kamu yakin ingin menghapus portfolio ini?</p>
        <form :action="`{{ url('portfolios') }}/` + portfolioId" method="POST" class="flex justify-end space-x-2">
            @csrf
            @method('DELETE')
            <button type="button" @click="deleteModal = false" class="px-4 py-2 bg-gray-300 rounded">Batal</button>
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Hapus</button>
        </form>
    </div>
</div>
