<x-home-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Info Artis Tato --}}
        <div class="flex flex-col md:flex-row items-start gap-6 mb-10">
            <img src="{{ asset('storage/' . $artist->gambar) }}" alt="{{ $artist->nama_artis_tato }}" class="w-40 h-40 object-cover rounded-lg shadow">

            <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-800">{{ $artist->nama_artis_tato }}</h2>
                <p class="text-sm text-gray-500 mb-2">Tahun mulai menato: {{ $artist->tahun_menato }}</p>

                <div class="flex space-x-4 mt-2">
                    @if($artist->instagram)
                    <a href="{{ $artist->instagram }}" target="_blank" class="text-blue-600 hover:underline">Instagram</a>
                    @endif
                    @if($artist->tiktok)
                    <a href="{{ $artist->tiktok }}" target="_blank" class="text-pink-600 hover:underline">TikTok</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Gallery Portofolio --}}
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Galeri Portofolio</h3>

        <div x-data="{
                        showModal: false,
                        portfolios: {{ $relatedPortfolios->toJson() }},
                        currentIndex: 0,
                        get current() {
                            return this.portfolios[this.currentIndex];
                        },
                        next() {
                            if (this.currentIndex < this.portfolios.length - 1) this.currentIndex++;
                        },
                        prev() {
                            if (this.currentIndex > 0) this.currentIndex--;
                        }
                    }">
            <!-- Gallery Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="(item, index) in portfolios" :key="item.id_portfolio">
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden cursor-pointer"
                        @click="currentIndex = index; showModal = true">
                        <img :src="'/storage/' + item.gambar" :alt="item.judul" class="w-full h-48 object-cover hover:scale-105 transition duration-300">
                    </div>
                </template>
            </div>

            <!-- Modal Swipeable Detail -->
            <div x-show="showModal" x-transition x-cloak class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
                    <button @click="showModal = false" class="absolute top-1 right-2 text-gray-700 text-2xl hover:text-gray-900">&times;</button>

                    <img :src="'/storage/' + current.gambar" :alt="current.judul" class="w-full h-56 object-cover rounded mb-4">
                    <h2 class="text-xl font-bold text-gray-800 mb-2" x-text="current.judul"></h2>
                    <p class="text-sm text-gray-600" x-text="current.deskripsi"></p>

                    <!-- Swipe Nav -->
                    <div class="mt-6 flex justify-between">
                        <button @click="prev" :disabled="currentIndex === 0" class="px-3 py-2 rounded bg-gray-200 hover:bg-gray-300 disabled:opacity-50">&larr;</button>
                        <button @click="next" :disabled="currentIndex === portfolios.length - 1" class="px-3 py-2 rounded bg-gray-200 hover:bg-gray-300 disabled:opacity-50">&rarr;</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-home-layout>