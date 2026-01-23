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
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4">
                    <div class="p-4 bg-blue-100 text-blue-600 rounded-full">
                        📍
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Destinasi</p>
                        <p class="text-3xl font-bold text-gray-800">
                            {{ $totalDestinations }}
                        </p>
                    </div>
                </div>

                {{-- Placeholder card --}}
                <div class="bg-white rounded-xl shadow p-6 flex items-center gap-4 opacity-70">
                    <div class="p-4 bg-green-100 text-green-600 rounded-full">
                        📈
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Booking</p>
                        <p class="text-3xl font-bold text-gray-400">
                            —
                        </p>
                    </div>
                </div>
            </div>

            {{-- CONTENT --}}
            <div class="bg-white rounded-xl shadow">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Selamat Datang 👋
                    </h3>
                </div>
                <div class="p-6 text-gray-600">
                    <p>
                        Kamu berhasil login sebagai <span class="font-semibold">Admin</span>.
                        Gunakan dashboard ini untuk mengelola destinasi dan memantau aktivitas sistem.
                    </p>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>