<x-home-layout>
    <div class="max-w-7xl mx-auto p-6">
        <!-- Form Search -->
        <!-- <form method="GET" action="{{ route('artis.list') }}" class="mb-8">
            <div class="flex items-center space-x-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama artis..."
                    class="w-full border border-gray-300 rounded-full px-5 py-3 text-sm focus:ring-2 focus:ring-orange-400 focus:border-orange-400 transition">
                <x-primary-button type="submit" class="px-6 py-3 rounded-full flex justify-center">
                    Cari
                </x-primary-button>
            </div>
        </form> -->

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @forelse ($artis_tatos as $artis)
            <div class="bg-white shadow-md rounded-2xl overflow-hidden flex flex-col hover:shadow-lg transition duration-300">
                <div class="w-full h-48 overflow-hidden">
                    <img
                        src="{{ asset('storage/' . $artis->gambar) }}"
                        alt="{{ $artis->nama_artis_tato }}"
                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5 flex flex-col flex-1 justify-center items-center">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">{{ $artis->nama_artis_tato }}</h3>

                    <p class="text-sm text-gray-500 mb-2">
                        <span class="font-semibold text-gray-700">Tahun Mulai Menato:</span> {{ $artis->tahun_menato }}
                    </p>

                    <div class="mb-3 text-center">
                        <p class="text-sm text-gray-500 mb-1 font-semibold">Skill :</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach ($artis->artisKategoris as $artisKategori)
                            <span class="inline-block bg-orange-100 text-orange-700 text-xs px-2 py-1 rounded-full">
                                {{ $artisKategori->kategori->nama_kategori }}
                            </span>
                            @endforeach
                        </div>
                    </div>

                    @if ($artis->instagram)
                    <p class="text-sm text-gray-500 mb-1">
                        <span class="font-semibold text-gray-700">Instagram:</span>
                        <a href="https://instagram.com/{{ $artis->instagram }}" target="_blank" class="text-orange-500 hover:underline">{{ '@' . $artis->instagram }}</a>
                    </p>
                    @endif

                    @if ($artis->tiktok)
                    <p class="text-sm text-gray-500 mb-3">
                        <span class="font-semibold text-gray-700">TikTok:</span>
                        <a href="https://tiktok.com/@{{ $artis->tiktok }}" target="_blank" class="text-orange-500 hover:underline">{{ '@' . $artis->tiktok }}</a>
                    </p>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-4 text-center text-gray-400">
                Tidak ada artis ditemukan.
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $artis_tatos->links() }}
        </div>
    </div>
</x-home-layout>