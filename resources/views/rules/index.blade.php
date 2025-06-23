<x-app-layout>
    <div x-data="rulesManager()" x-init="initModal({{ json_encode(['errors' => $errors->any(), 'old' => old(), ]) }})" x-cloak>
        <div class="max-w-7xl mx-auto py-6">
            <h2 class="text-2xl font-bold mb-4">Manajemen Rules SPK</h2>

            <div class="flex justify-between items-center mb-4">
                <form method="GET" action="{{ route('rules.index') }}" class="flex space-x-2">
                    <x-text-input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama rules..." />
                    <x-primary-button type="submit" class="px-4 py-1 rounded">Cari</x-primary-button>
                </form>
                <x-primary-button @click="addModal = true" class="px-4 py-2 rounded">Tambah Rules</x-primary-button>
            </div>

            <!-- success or error message -->
            @if (session('success'))
            <x-alert type="success" class="mb-4">
                {{ session('success') }}
            </x-alert>
            @endif
            @if (session('error'))
            <x-alert type="error" class="mb-4">
                {{ session('error') }}
            </x-alert>
            @endif

            <table class="w-full border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Nama</th>
                        <th class="p-2 text-left">Kondisi If</th>
                        <th class="p-2 text-left">Hasil Then</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rules as $rule)
                    <tr class="border-t">
                        <td class="p-2">{{ $rule->nama }}</td>
                        <td class="p-2">{{ is_array($rule->kondisi_if) ? json_encode($rule->kondisi_if) : $rule->kondisi_if }}</td>
                        <td class="p-2">{{ is_array($rule->hasil_then) ? json_encode($rule->hasil_then) : $rule->hasil_then }}</td>

                        <td class="p-2 space-x-2">
                            <button
                                @click='setEdit(@json($rule))'
                                class="text-blue-600">Edit</button>
                            <button
                                @click="confirmDelete({{ $rule->id }})"
                                class="text-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Tidak ada rule ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $rules->appends(['search' => request('search')])->links() }}
            </div>

            @include('rules.partials.add-modal')
            @include('rules.partials.edit-modal')
            @include('rules.partials.delete-modal')
        </div>
    </div>
    <script>
        function rulesManager() {
            return {
                addModal: false,
                editModal: false,
                deleteModal: false,
                lokasi: {
                    id: null,
                    nama: '',
                    kondisi_if: '',
                    hasil_then: '',
                },
                ruleId: null,

                initModal(data) {
                    if (data.errors) {
                        if (data.old && data.old.id) {
                            this.lokasi = {
                                id: data.old.id,
                                nama: data.old.nama,
                                kondisi_if: data.old.kondisi_if,
                                hasil_then: data.old.hasil_then,
                            };
                            this.editModal = true;
                        } else {
                            this.addModal = true;
                        }
                    }
                },

                setEdit(data) {
                    this.rule = {
                        id: data.id,
                        nama: data.nama,
                        kondisi_if: typeof data.kondisi_if === 'string' ? data.kondisi_if : JSON.stringify(data.kondisi_if, null, 2),
                        hasil_then: typeof data.hasil_then === 'string' ? data.hasil_then : JSON.stringify(data.hasil_then, null, 2),
                    };
                    this.editModal = true;
                },

                confirmDelete(id) {
                    this.ruleId = id;
                    this.deleteModal = true;
                }
            }
        }
    </script>
</x-app-layout>