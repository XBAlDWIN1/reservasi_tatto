<x-home-layout>
    <div class="container mx-auto px-5 py-2">
        <div class="grid">
            @foreach ($portfolios as $portfolio)
            <a href="{{ route('portfolio.artist', ['id_portfolio' => $portfolio->id_portfolio]) }}">
                <div class="grid-item w-1/2 md:w-1/3 lg:w-1/4 p-1 md:p-2 relative group">
                    <img
                        alt="{{ $portfolio->judul }}"
                        class="block w-full rounded-lg object-cover object-center"
                        src="{{ asset('storage/' . $portfolio->gambar) }}" />

                    <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex flex-col justify-center items-center text-white text-center p-4">
                        <h3 class="text-sm font-semibold">{{ $portfolio->judul }}</h3>
                        <p class="text-xs italic">Artis: {{ $portfolio->artisTato->nama_artis_tato?? '-' }}</p>
                        <p class="text-xs mt-1">{{ Str::limit($portfolio->deskripsi, 100) }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <div id="pagination-container" class="text-center mt-8">
            @if ($portfolios->hasMorePages())
            <button id="load-more-button"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                data-next-page="{{ $portfolios->nextPageUrl() }}">
                Muat Lebih Banyak
            </button>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>

    <script>
        // Gunakan 'window.onload' untuk memastikan SEMUA sumber daya (gambar, css) sudah dimuat
        window.onload = function() {
            const grid = document.querySelector('.grid');
            if (!grid) return; // Hentikan jika grid tidak ditemukan

            // Inisialisasi Isotope di dalam imagesLoaded untuk kepastian ganda
            const iso = new Isotope(grid, {
                itemSelector: '.grid-item',
                layoutMode: 'masonry',
                percentPosition: true,
                masonry: {
                    columnWidth: '.grid-item'
                }
            });

            // Gunakan imagesLoaded untuk memastikan semua dimensi gambar benar, lalu RERENDER layout
            imagesLoaded(grid).on('progress', function() {
                // Saat setiap gambar dimuat, panggil layout ulang
                iso.layout();
            }).on('done', function() {
                // Hapus background placeholder setelah semua gambar selesai
                const images = grid.querySelectorAll('img');
                images.forEach(img => img.classList.add('is-loaded'));
            });

            // Logika untuk Tombol "Load More"
            const loadMoreButton = document.querySelector('#load-more-button');
            if (loadMoreButton) {
                loadMoreButton.addEventListener('click', function() {
                    // ... (Logika Load More dari jawaban sebelumnya tetap sama) ...
                });
            }
        };
    </script>
    @endpush
</x-home-layout>