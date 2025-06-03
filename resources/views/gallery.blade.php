<x-home-layout>
    <div class="container mx-auto px-5 py-2">
        <div class="grid" data-isotope='{ "itemSelector": ".grid-item", "layoutMode": "masonry" }'>
            @foreach ($portfolios as $portfolio)
            <div class="grid-item w-1/2 md:w-1/3 lg:w-1/4 p-1 md:p-2">
                <img
                    alt="{{ $portfolio->judul }}"
                    class="block w-full rounded-lg object-cover object-center"
                    src="{{ asset('storage/portfolio/' . $portfolio->gambar) }}" />
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