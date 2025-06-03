<x-home-layout>
    <section class="max-w-6xl mx-auto px-6 md:px-10 py-16">
        <h1 class="text-4xl font-bold text-center text-gray-900 mb-10 tracking-wide">
            Hubungi <span class="text-orange-600">Kami</span>
        </h1>

        <div class="grid md:grid-cols-2 gap-10 bg-white p-8 rounded-2xl shadow-xl">
            {{-- Form --}}
            <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="name" class="block mb-1 text-gray-700 font-medium">Nama</label>
                    <input type="text" name="name" id="name" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm">
                </div>
                <div>
                    <label for="message" class="block mb-1 text-gray-700 font-medium">Pesan</label>
                    <textarea name="message" id="message" rows="5" required
                        class="w-full border border-gray-300 rounded-md px-4 py-2 focus:ring-2 focus:ring-orange-500 focus:outline-none shadow-sm resize-none"></textarea>
                </div>
                <button type="submit"
                    class="w-full bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Kirim via WhatsApp
                </button>
            </form>

            {{-- Informasi Kontak --}}
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-2">Informasi Kontak</h2>
                    <p class="text-gray-700"><strong>WhatsApp:</strong> <a href="https://wa.me/6285252630364" class="text-orange-600 hover:underline">+62 852-5263-0364</a></p>
                    <p class="text-gray-700"><strong>Email:</strong> <a href="mailto:info@tatostudio.com" class="text-orange-600 hover:underline">info@tatostudio.com</a></p>
                </div>

                <div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-3">Lokasi Studio</h2>
                    <div class="rounded-lg overflow-hidden shadow-md">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.910456494918!2d110.3742581750051!3d-7.799304592220866!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5711e3ae1d37%3A0xb6b19e7c7eead74b!2sMK%20Tattooart!5e0!3m2!1sid!2sid!4v1747586723044!5m2!1sid!2sid"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-home-layout>