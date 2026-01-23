<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800">
                📍 Daftar Destinasi
            </h2>

            <a href="{{ route('dashboard') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b flex justify-between items-center">
                    <p class="text-gray-600">
                        Total: <span class="font-semibold">{{ $destinations->count() }}</span> destinasi
                    </p>

                    <a href="{{ route('destinations.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        + Tambah Destinasi
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($destinations as $destination)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $loop->iteration + ($destinations->currentPage()-1)*$destinations->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $destination->name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm flex justify-end gap-2">
                                        <a href="{{ route('destinations.edit', $destination) }}"
                                           class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                            Edit
                                        </a>

                                        <form action="{{ route('destinations.destroy', $destination) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus destinasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                        Belum ada destinasi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $destinations->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
