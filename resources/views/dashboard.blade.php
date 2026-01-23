<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            📊 Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('destinations.index') }}"
                        class="bg-white rounded-xl shadow p-6 flex items-center gap-4
                                hover:shadow-lg transition cursor-pointer">

                            <div class="p-4 bg-blue-100 text-blue-600 rounded-full">
                                📍
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">Total Destinasi</p>
                                <p class="text-3xl font-bold text-gray-800">
                                    {{ $totalDestinations }}
                                </p>
                                <p class="text-xs text-blue-600 mt-1">
                                    Lihat semua destinasi →
                                </p>
                            </div>
                        </a>
            </div>
    </div>
</x-app-layout>
