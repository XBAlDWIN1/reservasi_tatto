<x-home-layout>
    <div class="container mx-auto px-5 py-2">
        <div class="grid" data-isotope='{ "itemSelector": ".grid-item", "layoutMode": "masonry" }'>
            @foreach ($portfolios as $portfolio)
            <div class="grid-item w-1/2 md:w-1/3 lg:w-1/4 p-1 md:p-2 relative group">
                <img
                    alt="{{ $portfolio->judul }}"
                    class="block w-full rounded-lg object-cover object-center"
                    src="{{ asset('storage/' . $portfolio->gambar) }}" />

                <!-- Overlay saat hover -->
                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-lg flex flex-col justify-center items-center text-white text-center p-4">
                    <h3 class="text-sm font-semibold">{{ $portfolio->judul }}</h3>
                    <p class="text-xs italic">Artis: {{ $portfolio->artisTato->nama_artis_tato?? '-' }}</p>
                    <p class="text-xs mt-1">{{ Str::limit($portfolio->deskripsi, 100) }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $portfolios->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        var elem = document.querySelector('.grid');
        var iso;
        imagesLoaded(elem, function() {
            iso = new Isotope(elem, {
                itemSelector: '.grid-item',
                layoutMode: 'masonry'
            });
        });
    </script>
    @endpush
</x-home-layout>